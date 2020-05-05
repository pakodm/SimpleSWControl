import { FormBuilder, Validators, FormGroup, FormControl } from '@angular/forms';
import * as moment from 'moment';

const dateRegEx = new RegExp('^([0-9]|-){1,}T([0-9]|:){1,}(.*)?$');
const fnacRegEx = new RegExp('^(\d{2})(\d{2})(\d{4})$');
// tslint:disable-next-line:max-line-length
// const DateRegEx = new RegExp('^(?:(?:31(\/|-|\.)(?:0?[13578]|1[02]))\1|(?:(?:29|30)(\/|-|\.)(?:0?[1,3-9]|1[0-2])\2))(?:(?:1[6-9]|[2-9]\d)?\d{2})$|^(?:29(\/|-|\.)0?2\3(?:(?:(?:1[6-9]|[2-9]\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\d|2[0-8])(\/|-|\.)(?:(?:0?[1-9])|(?:1[0-2]))\4(?:(?:1[6-9]|[2-9]\d)?\d{2})$');

function getSiteCollectionUrl() {
  if (window
    && 'location' in window
    && 'protocol' in window.location
    && 'pathname' in window.location
    && 'host' in window.location) {
    let baseUrl = window.location.protocol + '//' + window.location.host;
    const pathname = window.location.pathname;
    const siteCollectionDetector = '/#/';
    if (pathname.indexOf(siteCollectionDetector) >= 0) {
      baseUrl += pathname.substring(0, pathname.indexOf('/', siteCollectionDetector.length));
    }
    return baseUrl;
  }
  return null;
}

export function getAPIBaseUrl() {
  let urlAPI = 'http://local.impulsys.com.mx/public';
  const currentSite = getSiteCollectionUrl();
  if (currentSite != null) {
    if (currentSite.indexOf('148.240.231.10') >= 0) {
      urlAPI = 'http://148.240.231.10:5000';
    } else if (
      (currentSite.indexOf('localhost') >= 0) &&
      (currentSite.indexOf('4200') === -1)
    ) {
      urlAPI = 'http://localhost:5000';
    }
  }
  // console.log(urlAPI);
  return urlAPI;
}

export function getReportDesignerURL() {
  return 'http://mvc.meridianlakes.ml/Designer';
}

export function formatDSDates(ds) {
  moment.locale('es-en');
  if (ds instanceof Array && ds.length > 0) {
    ds.forEach((item => {
      Object.keys(item).forEach((key => {
        if (dateRegEx.test(item[key])) {
          item[key] = moment(item[key]).format('DD/MMM/YYYY');
        }
        if (typeof item[key] === 'boolean') {
          if (item[key] === true) {
            item[key] = 'Si';
          } else {
            item[key] = 'No';
          }
        }
      }));
    }));
  }
  return ds;
}

export function formatDate(ds) {
  if (dateRegEx.test(ds)) {
    ds = moment(ds).locale('es-do').format('LL');
  }
  return ds;
}

export function formatoFecha(date) {
  const hora = moment(date).format('h:mm:ss a');
  const fecha = moment(date).format('DD/MM/YYYY');
  return fecha + ' ' + hora;
}

export function maskInputValue(s, maskType) {
  let maskedValue = '';
  if (maskType === 'fnac') {
    maskedValue = s.replace(fnacRegEx, '$1/$2/$3');
  }
  return maskedValue;
}

export function maskDateValue(s) {
  if (s.length === 2) {
    s = s + '/';
  }
  if (s.length === 5) {
    s = s + '/';
  }
  return s;
}

export function calculaEdad(dateString: string) {
  let edad = {};
  let isAgeError = false;
  let years = 0;
  let months = 0;
  let days = 0;
  const date2Calc = moment(dateString, 'DD/MM/YYYY').toDate();
  if (moment(date2Calc).isValid()) {
    years = moment().diff(date2Calc, 'years');
    months = moment().diff(date2Calc, 'months', true);
    if (months > 12) {
      months = months - (years * 12);
    }
    const decMonth = months - Math.floor(months);
    days = Math.floor(decMonth * 30);
  }
  isAgeError = (years < 0) ? true : false;
  edad = {
    'years': years,
    'meses': Math.floor(months),
    'dias': days,
    'error': isAgeError
  };
  return edad;
}

export function markRequiredFields(formGroup: any) {
  for (const inner in formGroup.controls) {
    if (formGroup.controls.hasOwnProperty(inner)) {
      formGroup.get(inner).markAsTouched();
      formGroup.get(inner).updateValueAndValidity();
    }
  }
}

export function isEmpty(s: string) {
  return (s) ? s.trim().length === 0 : true;
}

export function getAlertDuration(): number {
  return 5000;
}

function getMonthName(m) {
  if (m.indexOf('0') === 0) { m = m.substring(1); }
  let m_name = '';
  switch (parseInt(m, 10)) {
    case 1: m_name = 'January'; break;
    case 2: m_name = 'February'; break;
    case 3: m_name = 'March'; break;
    case 4: m_name = 'April'; break;
    case 5: m_name = 'May'; break;
    case 6: m_name = 'June'; break;
    case 7: m_name = 'July'; break;
    case 8: m_name = 'August'; break;
    case 9: m_name = 'September'; break;
    case 10: m_name = 'October'; break;
    case 11: m_name = 'November'; break;
    case 12: m_name = 'December'; break;
  }
  return m_name;
}

export function getTimeBetweenDates(ds1, ds2) {
  return (ds2 - ds1) / 1000 / 60 / 60 / 24;
  /*
  let date1 = ds1.split(' ');
  let date2 = ds2.split(' ');
  let fecha1 = date1[0].split('-');
  let fecha2 = date2[0].split('-');
  let month1 = getMonthName(fecha1[1]);
  let month2 = getMonthName(fecha2[1]);
  let d1 = month1+", "+fecha1[2]+" "+fecha1[0]+" "+date1[1];
  let d2 = month2+", "+fecha2[2]+" "+fecha2[0]+" "+date2[1];
  let ms1 = Date.parse(d1);
  let ms2 = Date.parse(d2);
  let dif = (ms2 - ms1) / 1000 / 60;
  return dif;
  */
}
export function getMessagesBox(Action: string, Name: string) {
  return {
    title : `${Action} ${Name}`,
    content : `¿Seguro que desea ${Action} ${Name}? Nota: Este cambio no se puede deshacer.`
  };
}

export function calculaTiempo(inicio: string, fin: string) {
  let edad = {};
  let isAgeError = false;
  let years = 0;
  let months = 0;
  let days = 0;
  const fecha1 = moment(inicio);
  const fecha2 = moment(fin);
  if (moment(fecha1).isValid() && moment(fecha2).isValid()) {
    years = fecha1.diff(fecha2, 'years');
    months = fecha1.diff(fecha2, 'months', true);
    if (months > 12) {
      months = months - (years * 12);
    }
    const decMonth = months - Math.floor(months);
    days = Math.floor(decMonth * 30);
  }
  isAgeError = (years < 0) ? true : false;
  edad = {
    'years': years,
    'meses': Math.floor(months),
    'dias': days,
    'error': isAgeError
  };
  return edad;
}
