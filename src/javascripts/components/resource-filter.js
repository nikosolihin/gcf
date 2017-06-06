import getQueryParams from '../lib/getQueryParams'

export default class ResourceFilter {
  constructor(el) {
    this.$el = $(el)

    // Selectors
    this.$panel = this.$el.find('.ArchiveResource-filterPanel')
    this.$search = this.$el.find('.ArchiveResource-searchBox')
    this.$sort = this.$el.find('.ArchiveResource-sort')
    this.$page = this.$el.find('.ArchiveResource-paginationPage')
    this.$month = $("[data-select='month'] > select")
    this.$year = $("[data-select='year'] > select")
    this.$author = $("[data-select='author'] > select")
    this.$checked = $(".Checkbox--active")

    // Modules
    this.$result = $("[data-component='resource-result']")
    this.$pill = $("[data-component='pill']")
    this.$checkbox = $("[data-component='checkbox']")

    // Delegation
    this.button = '.ArchiveResource-filterButton'
    this.filterType = '.ArchiveResource-filterType'
    this.$reset = '.ArchiveResource-filterReset'
    this.$submit = '.ArchiveResource-filterSubmit'

    // States
    this.open = 'ArchiveResource-filter--open'
    this.sortActive = 'ArchiveResource-sort--active'
    this.checked = 'Checkbox--active'
    this.pillActive = 'Pill--active'

    // Should panel open automatically
    // this.willOpen = location.search ? true : false
    this.willOpen = true

    getQueryParams()
    this.prepPanel()
    this.attachEvents()
    this.fetchResources()
  }

  attachEvents() {
    $(document).keydown( (event) => {
      if(event.which == 13) {  // Enter Key
        event.preventDefault()
        this.updateURL()
        this.fetchResources()
      }
      if(event.which == 27) {  // Esc Key
        event.preventDefault()
        if (this.$el.hasClass(this.open)) {
          this.$el.removeClass(this.open)
        }
      }
    })

    // Toggle filter panel
    this.$el.on('click', this.button, (event) => {
      this.$el.toggleClass(this.open)
    })

    // Checkboxes
    .on('click', this.filterType, (event) => {
      $(event.target).closest(this.filterType).find('.Checkbox').toggleClass(this.checked)
      this.updateURL()
    })

    // Pills
    .on('click', '.Pill', (event) => {
      this.updateURL()
    })

    // Keyword Search
    .on('change', this.$search, (event) => {
      this.updateURL()
    })

    // Reset
    .on('click', this.$reset, (event) => {
      this.clearAll()
    })

    // Submit
    .on('click', this.$submit, (event) => {
      this.updateURL()
      this.fetchResources()
    })

    this.$sort.on('click', (event) => {
      event.preventDefault()
      $('.ArchiveResource-sort--active').removeClass(this.sortActive)
      $(event.target).addClass(this.sortActive)
      this.updateURL()
      this.fetchResources()
    })

    this.$author.on('change', (event) => {
      this.updateURL()
    })

    this.$month.on('change', (event) => {
      this.updateURL()
    })

    // Year Dropdown triggering month dropdown
    this.$year.on('change', (event) => {
      if ( $(event.target).val() !== "any" ) {
        $(".ArchiveResource-filterDateMonth").addClass('ArchiveResource-filterDateMonth--open')
        this.updateURL()
      } else {
        $(".ArchiveResource-filterDateMonth").removeClass('ArchiveResource-filterDateMonth--open')
        this.$month.val('any')
        this.updateURL()
      }
    })
  }

  prepPanel() {
    if (gcf.types != 'any') {
      gcf.types.forEach((type) => {
        this.$checkbox.filter("[data-type='"+ type +"']").toggleClass(this.checked)
      })
    }
    if (gcf.topics != 'any') {
      gcf.topics.forEach((topic) => {
        this.$pill.filter("[data-topic='"+ topic +"']").toggleClass('Pill--active')
      })
    }
    if (gcf.month != 'any') {
      this.$month.val(gcf.month)
    }
    if (gcf.year != 'any') {
      this.$year.val(gcf.year)
    }
    if (gcf.author != 'any') {
      this.$author.val(gcf.author)
    }
    if (gcf.keyword) {
      this.$search.val( decodeURI(gcf.keyword) )
    }
    // Sort and page don't need conditionals
    this.$sort.filter("[data-sort='"+ gcf.sort +"']").toggleClass('ArchiveResource-sort--active')

    if (this.willOpen) {
      setTimeout(() => {
        this.$el.toggleClass(this.open)
      }, 300)
    }
  }

  updateURL() {
    let url = '?utf8=✓'

    // Types
    if ( $(".Checkbox--active").length ) {
      gcf.types = []
      $(".Checkbox--active").each((index, el) => {
        gcf.types[gcf.types.length] = $(el).data('type')
      })
      url += `&types=${gcf.types.join(',')}`
    }  else {
      gcf.types = 'any'
    }

    // Topics
    if ( $('.Pill--active').length ) {
      gcf.topics = []
      $('.Pill--active').each((index, el) => {
        gcf.topics[gcf.topics.length] = $(el).data('topic')
      })
      url += `&topics=${gcf.topics.join(',')}`
    } else {
      gcf.topics = 'any'
    }

    // Month
    if ( this.$month.val() !== "any" ) {
      gcf.month = this.$month.val()
      url += `&month=${gcf.month}`
    } else {
      gcf.month = 'any'
    }

    // Year
    if ( this.$year.val() !== "any" ) {
      gcf.year = this.$year.val()
      url += `&year=${gcf.year}`
    }  else {
      gcf.year = 'any'
    }

    // Author
    if ( this.$author.val() !== "any" ) {
      gcf.author = this.$author.val()
      url += `&author=${gcf.author}`
    } else {
      gcf.author = 'any'
    }

    // Keyword
    if ( this.$search.val() !== "" ) {
      gcf.keyword = this.$search.val()
      url += `&q=${gcf.keyword}`
    } else {
      gcf.keyword = null
    }

    // Sort
    gcf.sort = $('.ArchiveResource-sort--active').data('sort')
    url += `&sort=${gcf.sort}`

    // Set history
    window.history.pushState(null, document.title, url)
  }

  clearAll() {
    this.$checkbox.removeClass(this.checked)
    this.$pill.removeClass(this.pillActive)
    this.$search.val('')
    this.$author.val('any')
    this.$month.val('any')
    this.$year.val('any')
    this.updateURL()
    this.fetchResources()
  }

  fetchResources() {
    this.$result.trigger('fetch')
  }

}
