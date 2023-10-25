import { createSlice } from '@reduxjs/toolkit'
import axios from '../../helpers/axios';
const qs = require("qs");

// Recaptcha state
export const recaptchaSlice = createSlice({
  name: 'recaptchaState',
  initialState: {
    siteKey: '',
    secretKey: ''
  },
  reducers: {
    setSiteKey: (state, action) => {
      state.siteKey = action.payload;
    },
    setSecretKey: (state, action) => {
      state.secretKey = action.payload;
    },
  },
})

export const { setSiteKey,setSecretKey } = recaptchaSlice.actions

// The function below is called a selector and allows us to select a value from
// the state. Selectors can also be defined inline where they're used instead of
// in the slice file. For example: `useSelector((state) => state.counter.value)`
export const siteKey = (state) => state.recaptchaState.siteKey
export const secretKey = (state) => state.recaptchaState.secretKey

// Get recaptcha values
export const fetchRecaptchaValues = () => (dispatch) => {
  
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_get_recaptcha_data",
    nonce: fscs_settings.settings_nonce,
    data: []
  })).then(({data}) => {
    dispatch(setSiteKey(data?.site_key));
    dispatch(setSecretKey(data?.secret_key));
  });
  
}

// Save recaptcha values
export const saveRecaptchaValues = ({values, cb}) => (dispatch) => {
  
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_save_recaptcha_data",
    nonce: fscs_settings.settings_nonce,
    ...values
  })).then(({data}) => {
    dispatch(setSiteKey(data?.site_key));
    dispatch(setSecretKey(data?.secret_key));
    if (typeof cb === "function") cb(data);
  });
  
}

export default recaptchaSlice.reducer