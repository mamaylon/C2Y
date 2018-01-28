const Utils = {}
Utils.submit = function (form, uri, sender, method) {
  let data = {}
  for (let i in form)
    form[i] != 0 && form[i] != '' ? data[i] = form[i] : 0
  return (sender[ method ])(uri, method != 'get' ? data : { params: data })
}

export default Utils