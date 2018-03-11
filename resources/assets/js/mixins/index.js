const map = {
  '01': 'Janeiro', '02': 'Fevereiro', '03': 'Março',
  '04': 'Abril',   '05': 'Maio',      '06': 'Junho',
  '07': 'Julho',   '08': 'Agosto',    '09': 'Setembro',
  '10': 'Outubro', '11': 'Novembro',  '12': 'Dezembro',
}
export default {
  methods: {
    toSize (url, size) {
      if (/facebook\.[\w\/.?]*width=([0-9]+)/i.test(url)) {
        return url.replace(/width=[0-9]+/i, `width=${size}`)
      }
      return `${url}?sz=${size}`
    },
    dateToLegible (date) {
      let regex = /([0-9]{4})-([0-9]{2})-([0-9]{2}) ([0-9]{2}):([0-9]{2})/i
      let match = regex.exec(date)
      return `${match[4]}:${match[5]}, ${match[3]} de ${map[ match[2] ].substr(0,3)}. de ${match[1]}`
    }
  }
}