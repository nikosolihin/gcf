import moment from 'moment'
import Mustache from 'mustache'
import paramReplace from '../lib/paramReplace'

export default class ResourceResult {
  constructor(el) {
    this.$el = $(el)
    this.$loader = $(".Loader")
    this.$template = $("#ResourceObject").html()
    this.$header = $(".ArchiveResource-header")

    // Modules
    this.$pagination = $("[data-component='pagination']")

    // Data attribute options
    let options = this.$el.data('options')
    this.domain = options.domain
    this.ppp = options.ppp
    this.on_word = options.on_word
    this.by_word = options.by_word
    this.published_word = options.published_word
    this.allTypes = options.types
    this.allTopics = options.topics
    this.allAuthors = options.authors
    this.emptyMsg = options.emptyMsg
    this.fallback = {'image': options.fallbackImage, 'profile': options.fallbackProfile},
    this.url = window.location.href

    // States
    this.fade = 'ArchiveResource-result--fade'
    this.headerFade = 'ArchiveResource-header--fade'
    this.showLoader = 'Loader--show'

    this.attachEvents()
  }

  attachEvents() {
    this.$el.on({
      'fetch': (event) => {
        this.fetchResources()
      }
    })
  }

  fetchResources() {
    let dataObject = {}
    dataObject.filter = {}
    dataObject.page = gcf.page
    dataObject.per_page = this.ppp

    // Sort
    if (gcf.sort == "popular") {
      dataObject.filter.meta_key = 'popular_posts'
      dataObject.filter.orderby = 'meta_value_num'
      dataObject.order = 'desc'
    } else {
      dataObject.orderby = gcf.sort
    }

    // Search keyword
    if (gcf.keyword) {
      dataObject.search = gcf.keyword
    }

    // Types
    if (gcf.types != 'any') {
      dataObject.filter.resource_type = gcf.types.join(',')
    }

    // Topics
    if (gcf.topics != 'any') {
      dataObject.filter.resource_topic = gcf.topics.join(',')
    }

    // Author
    if (gcf.author != 'any') {
      dataObject.author = gcf.author
    }

    // Date
    if (gcf.year != 'any') {
      if (gcf.month != 'any') {
        // Year and month are set
        let month = parseInt(gcf.month),
          year = parseInt(gcf.year)

        dataObject.before = new Date(year, month + 1, 1).toISOString()
        dataObject.after = new Date(year, month, 1).toISOString()

      } else {
        // Year is set, but not month
        let year = parseInt(gcf.year)

        dataObject.before = new Date(year+1, 0, 1).toISOString()
        dataObject.after = new Date(year, 0, 1).toISOString()
      }
    }

    // Fetch them
    $.ajax({
      url: `${this.domain}/wp-json/wp/v2/resources`,
      data: dataObject,
      type: "GET",
      dataType : "json",
      beforeSend: () => {
        this.$el.toggleClass(this.fade)
        this.$header.toggleClass(this.headerFade)
        this.$loader.toggleClass(this.showLoader)
      }
    })
    .always( () => {
      this.$el.empty()
    })
    .done( (data, status, xhr) => {
      if (data.length) {
        data.forEach((resource) => {
          let topics = resource.topics.map( id => {
            return {'topic': this.allTopics[id]['name']}
          }),

          // Do we need a fallback image?
          img = resource.acf.image,
          image = img ? img.base + 's400/' + img.title : this.fallback.image,

          // Do we have an author?
          authorName = this.allAuthors[resource.acf.author] ? this.allAuthors[resource.acf.author]['name'] : false,
          authorPhoto = this.allAuthors[resource.acf.author] ? this.allAuthors[resource.acf.author]['photo'] : false,

          // Teaser paragraph
          teaser = resource.acf.teaser,
          snippet = teaser.length > 150 ? teaser.substring(0, 150) + '...' : teaser,

          // For mustache
          templateVars = {
            id: resource.id,
            url: resource.link,
            title: resource.title.rendered,
            teaser: snippet,
            on: this.on_word,
            by: this.by_word,
            published: this.published_word,
            date: moment(resource.date).format('MMM D, Y'),
            typeName: this.allTypes[resource.types[0]]['name'],
            typeSlug: this.allTypes[resource.types[0]]['slug'],
            typeColor: this.allTypes[resource.types[0]]['color'],
            topics: topics,
            image: image,
            authorName: authorName,
            authorPhoto: authorPhoto
          }
          this.renderResource(templateVars)
        })
        this.$pagination.trigger('paginate', [parseInt(xhr.getResponseHeader('x-wp-totalpages'))])

      } else {
        this.renderResource({ empty: this.emptyMsg })
      }
      setTimeout(() => {
        this.$loader.toggleClass(this.showLoader)
        this.$el.toggleClass(this.fade)
        this.$header.toggleClass(this.headerFade)
      }, 250)
    })
    .fail( (xhr, status, errorThrown) => {
      this.renderResource({ error: `${xhr.responseJSON.message}` })
      this.$loader.toggleClass(this.showLoader)
      this.$el.toggleClass(this.fade)
      this.$header.toggleClass(this.headerFade)
      $('.ArchiveResource-sort--active').removeClass('ArchiveResource-sort--active')
      $('.ArchiveResource-sort[data-sort="date"]').addClass('ArchiveResource-sort--active')
    })
  }

  renderResource(data) {
    Mustache.parse(this.$template)
    this.$el.append( Mustache.render(this.$template, data) )
  }

}
