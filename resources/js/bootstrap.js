import axios from 'axios';
import moment from "moment";
window.axios = axios;
window.moment = moment;


window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

