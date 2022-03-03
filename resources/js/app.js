import {Datepicker} from 'vanillajs-datepicker';
import ru from '../../node_modules/vanillajs-datepicker/js/i18n/locales/ru.js';
import {tns} from "../../node_modules/tiny-slider/src/tiny-slider";
window.tns = tns;
Object.assign(Datepicker.locales, ru);

window.Datepicker = Datepicker;
window.Axios = require('axios');

import xmlHttpRequest from './xmlHttpRequest/xmlHttpRequest';
import refreshCart from './components/cart/refreshCart';
import getPreload from './components/card/functions/getPreload';
import getQuantity from './components/card/functions/qty';
import loadUnderOrder from './components/cart/loadUnderOrder';
import cartRemove from './components/cart/remove';
import flash from './components/alerts/flash';
import validator from './components/validate-errors/validator';
import countIcons from './components/card/countIcons';

//import close from './components/alerts/close';

require('./components/sticky-header/sticky');
//require('./components/homepage-slider/slider');
require('./components/accordion/accordion');
require('./components/tabs/tabs');
require('./components/leaders-sales/leaders-sales');
require('./components/product/moreGoods');
require('./components/card/cardIcons');
require('./components/form/mask/phone-mask');
require('./components/form/label/label-input-focus');
require('./components/form/radio/order-radio-input');
require('./components/mode-tile/tile');
require('./components/catalog-filter/attributes');
//require('./components/alerts/close');
require('./components/alerts/flash');
require('./components/login/login');
//require('./components/modals/webDevModal');
require('./components/verify-phone/phone');
require('./components/register/register');
require('./components/order-register/orderRegister');
require('./components/sticky-bar/sticky-bar');
require('./components/search/search');
require('./components/search/ajax-search');

import lazyLoad from './components/lazy-load';
import btnAdd from './components/card/btnAdd';
import btnQty from './components/card/btnQty';
import addCardTitleHeight from './components/card/card-title';
import underOrder from './components/cart/underOrder';


require('./events/_load');


