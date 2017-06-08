export default class Pill {
  constructor(el) {
    this.$el = $(el)

    // States
    this.active = 'Pill--active'

    this.attachEvents()
  }

  attachEvents() {
    // Direct Events
    this.$el.on({
      'click': (event) => {
        $(event.target).toggleClass(this.active)
      }
    })
  }
}
