export default {
  methods: {
    toSize (url, size) {
      if (/facebook\.[\w\/.?]*width=([0-9]+)/i.test(url)) {
        return url.replace(/width=[0-9]+/i, `width=${size}`)
      }
      return `${url}?sz=${size}`
    }
  }
}