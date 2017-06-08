window.gcf = {
  types: 'any',
  topics: 'any',
  month: 'any',
  year: 'any',
  author: 'any',
  page: 1,
  sort: 'relevance',
  keyword: null
}

const moduleElements = document.querySelectorAll('[data-component]')

for (var i = 0; i < moduleElements.length; i++) {
  const el = moduleElements[i]
  const name = el.getAttribute('data-component')
  const Module = require(`./${name}`).default
  new Module(el)
}

// Resource.js must be loaded last
$(function() {
  if ( $("body").hasClass('archive') ) {
    const Resource = require('./resource-filter').default
    new Resource("#archive-resource")
  }
});

window.$ = $
