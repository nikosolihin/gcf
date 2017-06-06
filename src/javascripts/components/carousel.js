import jQueryBridget from 'jquery-bridget'
import Flickity from 'flickity'

jQueryBridget('flickity', Flickity, $)

export default class Carousel {
  constructor(el) {
    this.$el = $(el)
    this.$body = this.$el.find('.Feed-body')
    this.carouselOptions = {
      cellSelector: '.Feed-item',
      prevNextButtons: true,
      pageDots: false,
      groupCells: 3
    }
    this.initialize()
  }

  initialize() {
    this.$body.flickity(this.carouselOptions)
  }
}
