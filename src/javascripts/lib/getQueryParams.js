module.exports = (str) => {
  let params =  (str || document.location.search).replace(/(^\?)/,'').split("&").map(function(n){return n = n.split("="),this[n[0]] = decodeURIComponent(n[1]),this}.bind({}))[0]

  gcf.types = params.types ? params.types.split(',') : 'any'
  gcf.topics = params.topics ? params.topics.split(',') : 'any'
  gcf.month = params.month || 'any'
  gcf.year = params.year || 'any'
  gcf.author = params.author || 'any'
  gcf.page = params.page || 1
  gcf.sort = params.sort || 'date'
  gcf.keyword = params.q ? encodeURI(params.q) : null

  return params
}
