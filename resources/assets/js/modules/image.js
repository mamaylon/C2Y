const Image = {}

Image.load = (e, callback) => {
  let files = e.target.files || e.dataTransfer.files
  if (!files.length)
    return
  createImage(files[0], callback)
}

function createImage (file, callback) {
  let reader = new FileReader()
  reader.onload = (e) => {
    if (callback)
      callback(e.target.result)
  }
  reader.readAsDataURL(file)
}

export default Image