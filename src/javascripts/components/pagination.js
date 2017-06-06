import paramReplace from '../lib/paramReplace'
import getQueryParams from '../lib/getQueryParams'

export default class Pagination {
  constructor(el) {
    this.$el = $(el)
    this.current = gcf.page
    this.total = 1

    // Selectors
    this.$prev = this.$el.find('.Pagination-prev')
    this.$next = this.$el.find('.Pagination-next')
    this.$pages = this.$el.find('.Pagination-pages')

    // Modules
    this.$result = $("[data-component='resource-result']")

    // Delegation
    this.nav = '.Pagination-nav'
    this.page = '.Pagination-page'

    // States
    this.currentPage = 'Pagination-page--current'
    this.show = 'Pagination--show'
    this.arrowInactive = 'Pagination-nav--inactive'

    getQueryParams()
    this.attachEvents()
  }

  attachEvents() {
    this.$el.on({
      // External Triggers
      'paginate': (event, total) => {
        this.current = gcf.page
        this.total = total
        this.reset()
        this.setupPages()
        this.setupArrows()
        this.toggle()
      }
    })

    // Prev and next arrows
    .on('click', this.nav, (event) => {
      let $target = $(event.target).closest(this.nav)

      // If this prev/next nav is active then go ahead
      if ( !$target.hasClass(this.arrowInactive) ) {
        let page = $target.data('page')
        gcf.page = page
        this.current = page
        this.updateURL()
        this.toggle()
        this.fetchResources()
      }
    })

    .on('click', this.page, (event) => {
      let $target = $(event.target).closest(this.page)

      // If this page button is not current then go ahead
      if ( !$target.hasClass(this.currentPage) ) {
        let page = $target.data('page')
        gcf.page = page
        this.current = page
        this.updateURL()
        this.toggle()
        this.fetchResources()
      }
    })
  }

  toggle() {
    this.$el.toggleClass(this.show)
  }

  reset() {
    this.$pages.empty()
    $('.Pagination-nav--inactive').removeClass(this.arrowInactive)
  }

  setupArrows() {
    this.$prev.data('page', this.current-1)
    this.$next.data('page', this.current+1)
    if (this.current == 1) {  // On first page
      this.$prev.addClass(this.arrowInactive).data('page', '0')

    } else if (this.current == this.total) {  // On last page
      this.$next.addClass(this.arrowInactive).data('page', '0')

    }
  }

  setupPages() {
    // Only 1 page is available, hide pagination
    if (this.total <= 1) {
      this.$el.hide()

    } else {  // 2 or more pages
      let pages = []

      // Always show the first page
      this.renderPages([1])

      if (this.total > 2) {  // 3 or more

        if (this.total < 7) {  // Don't use ellipsis
          for (var i = 2; i < this.total; i++) {
            pages[pages.length] = i
          }
          this.renderPages(pages)

        } else {  // Use ellipsis

          // Now the question becomes where to put the ellipsis
          if ( this.current >= 5 && this.current < this.total-2 ) {
            // in the middle
            pages = [this.current - 1, this.current, this.current + 1]
            this.renderEllipses()
            this.renderPages(pages)
            this.renderEllipses()

          } else if ( this.current <= 4 ) {

            // in the right
            for (var i = 2; i <= 5; i++) {
              pages[pages.length] = i
            }
            this.renderPages(pages)
            this.renderEllipses()

          } else if ( this.current >= this.total-2 ) {

            // in the left - display two last ones before the
            // absolute last
            pages = [this.total - 2, this.total-1]
            this.renderEllipses()
            this.renderPages(pages)
          }
        }
      }

      // Always show the last page
      this.renderPages([this.total])
    }
  }

  updateURL() {
    let updatedURL = paramReplace( location.search, 'page', this.current )
    window.history.pushState(null, document.title, updatedURL)
  }

  fetchResources() {
    window.scrollTo({top: 0, behavior: 'smooth'})
    setTimeout(() => {
      this.$result.trigger('fetch')
    }, 300)
  }

  renderPages(numbers) {
    numbers.forEach( number => {
      let isCurrent = number == this.current ? this.currentPage : '',
      template = `<a class="Pagination-page ${isCurrent}" data-page="${number}">${number}</a>`
      this.$pages.append(template)
    })
  }

  renderEllipses() {
    let template = `<div class="Pagination-page Pagination-ellipses spaced">&middot;&middot;&middot;</div>`
    this.$pages.append(template)
  }
}
