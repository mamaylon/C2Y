let like = function (action = true, data) {
  let params = action ? '' : `/${data}`
  let body = action ? data : {}
  return this.$http[ action ? 'post' : 'delete' ](`/api/like${params}`, body)
    .then(res => action ? res.body.data.like : res)
}

const Plugin = {
  install (Vue, options) {
    Vue.prototype.$like = like
  }
}

export default Plugin
