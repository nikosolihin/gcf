import jQueryBridget from 'jquery-bridget'
import Flickity from 'flickity-sync'

jQueryBridget('flickity', Flickity, $)

export default class Gallery {
  constructor(el) {
    this.$el = $(el)
    this.$body = this.$el.find('.Gallery-body')
    this.$preview = this.$el.find('.Gallery-preview')
    this.$captions = this.$el.find('.Gallery-captionItem')
    this.$current = this.$el.find('.Gallery-paginationCurrent')
    this.$total = this.$el.find('.Gallery-paginationTotal')

    this.current = 1
    this.total = 0
    this.count = 0
    this.galleryData = null
    this.offset = 0

    // Delegation
    this.left = '.Gallery-buttonLeft'
    this.right = '.Gallery-buttonRight'

    // States
    this.activeCaption = 'Gallery-captionItem--show'
    this.$activeCaption = $('.Gallery-captionItem--show')

    this.galleryOptions = {
      cellSelector: '.Gallery-cell',
      sync: '.Gallery-preview',
      wrapAround: true,
      pageDots: false,
      prevNextButtons: false,
      adaptiveHeight: false,
      // autoPlay: 8500,
      setGallerySize: false
    }
    this.previewOptions = {
      cellSelector: '.Gallery-previewCell',
      draggable: false,
      pageDots: false,
      prevNextButtons: false,
      adaptiveHeight: false,
      autoPlay: false,
      setGallerySize: false
    }

    this.initialize()
  }

  initialize() {
    this.galleryData = this.$body.flickity(this.galleryOptions).data('flickity')
    this.$preview.flickity(this.previewOptions)
    this.total = this.galleryData.cells.length
    this.attachEvents()
  }

  attachEvents() {
    this.$body.flickity('on', 'select', () => {
      // Change pagination
      this.current = this.galleryData.selectedIndex + 1
      this.$current.text(this.current)
      this.$total.text(this.total)

      // Change caption
      $('.Gallery-captionItem--show').removeClass('Gallery-captionItem--show')
      $('.Gallery-captionItem[data-caption-id="' + this.current + '"]').addClass(this.activeCaption)
    })
    this.$el.on('click', this.left, (event) => {
      event.preventDefault()
      this.galleryData.previous()
    })
    .on('click', this.right, (event) => {
      event.preventDefault()
      this.galleryData.next()
    })
  }
}
