import { createSlice } from '@reduxjs/toolkit'
import axios from '../../helpers/axios';
const qs = require("qs");

// Email state
export const emailSlice = createSlice({
  name: 'emailState',
  initialState: {
    loaded: false,
    modal_redirect_url: '',
    subject: '',
    cc: [],
    bcc: [],
    body: ''
  },
  reducers: {
    setLoaded: (state, action) => {
      state.loaded = action.payload;
    },
    setModalRedirectURL: (state, action) => {
      state.modal_redirect_url = action.payload;
    },
    setSubject: (state, action) => {
      state.subject = action.payload;
    },
    setCC: (state, action) => {
      state.cc = action.payload;
    },
    setBCC: (state, action) => {
      state.bcc = action.payload;
    },
    setBody: (state, action) => {
      state.body = action.payload;
    },
  },
})

export const { setLoaded, setModalRedirectURL, setSubject, setCC, setBCC, setBody } = emailSlice.actions

// The function below is called a selector and allows us to select a value from
// the state. Selectors can also be defined inline where they're used instead of
// in the slice file. For example: `useSelector((state) => state.counter.value)`
export const loaded = (state) => state.emailState.loaded
export const modal_redirect_url = (state) => state.emailState.modal_redirect_url
export const subject = (state) => state.emailState.subject
export const cc = (state) => state.emailState.cc
export const bcc = (state) => state.emailState.bcc
export const body = (state) => state.emailState.body

// Get email values
export const fetchEmailValues = () => (dispatch) => {
  
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_get_email_data",
    nonce: fscs_settings.settings_nonce,
    data: []
  })).then(({data}) => {
    dispatch(setLoaded(true));
    dispatch(setModalRedirectURL(data?.redirect_url));
    dispatch(setSubject(data?.subject));
    dispatch(setCC(data?.cc));
    dispatch(setBCC(data?.bcc));
    dispatch(setBody(data?.body));
  });
  
}

// Save email values
export const saveEmailValues = ({values, cb}) => (dispatch) => {
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_save_email_data",
    nonce: fscs_settings.settings_nonce,
    ...values
  })).then(({data}) => {
    dispatch(setModalRedirectURL(data?.redirect_url));
    dispatch(setSubject(data?.subject));
    dispatch(setCC(data?.cc));
    dispatch(setBCC(data?.bcc));
    dispatch(setBody(data?.body));
    if (typeof cb === "function") cb(data);
  });
  
}

// Send test email
export const sendTestEmail = ({email, cb}) => (dispatch) => {
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_settings_send_test_email",
    nonce: fscs_settings.settings_nonce,
    email
  })).then(({data}) => {
    if (typeof cb === "function") cb(data);
  });
  
}

export default emailSlice.reducer