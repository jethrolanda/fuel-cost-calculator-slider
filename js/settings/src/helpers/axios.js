import axios from 'axios';

export default axios.create({
  baseURL: fscs_settings.rest_url,
  timeout: 10000,
  headers: { "X-WP-Nonce" : fscs_settings.nonce }
});