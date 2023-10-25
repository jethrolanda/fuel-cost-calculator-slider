import axios from 'axios';

export default axios.create({
  baseURL: fscs_settings.rest_url,
  timeout: 5000,
  headers: { "X-WP-Nonce" : fscs_settings.nonce }
});

export const ajaxAxios = axios.create({
  baseURL: fscs_settings.ajax,
  timeout: 5000,
  data: { "settings_nonce" : fscs_settings.settings_nonce }
});