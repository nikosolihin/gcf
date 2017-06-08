// This cleans up the output of ACF Medium Editor.

export default class Editor {
  constructor(el) {
    this.$el = $(el)
    this.removeSpans()
    this.removeBreaks()
    this.removeEmptyParagraphs()
    this.replaceBWithStrong()
    this.replaceIWithEm()
    this.replaceInlineStyles()
  }

  removeSpans() {
    $('.Editor span').each( (index, element) => {
      let content = $(element).contents()
      $(element).replaceWith( () => {
        return content
      })
    })
  }

  removeBreaks() {
    $('.Editor br').remove()
  }

  removeEmptyParagraphs() {
    $('.Editor p').filter( (index, element) => {
      return $.trim( $(element).html() ) == ''
    }).remove()
  }

  replaceBWithStrong() {
    $('.Editor b').contents().unwrap().wrap('<strong/>')
  }

  replaceIWithEm() {
    $('.Editor i').contents().unwrap().wrap('<em/>')
  }

  replaceInlineStyles() {
    $('.Editor').find('[style]').each( function(index, el) {
      if ($(this).attr('style') == "text-align: right;") {
        $(this).addClass('right')
      } else if ($(this).attr('style') == "text-align: center;") {
        $(this).addClass('center')
      }
      $(this).removeAttr('style')
    })
  }
}
