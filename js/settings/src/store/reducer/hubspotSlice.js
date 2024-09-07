import { createSlice } from "@reduxjs/toolkit";
import axios from "../../helpers/axios";
const qs = require("qs");

// Recaptcha state
export const hubspotSlice = createSlice({
  name: "hubspotState",
  initialState: {
    loaded: false,
    apiKey: ""
  },
  reducers: {
    setLoaded: (state, action) => {
      state.loaded = action.payload;
    },
    setAPIKey: (state, action) => {
      state.apiKey = action.payload;
    }
  }
});

export const { setLoaded, setAPIKey } = hubspotSlice.actions;

// The function below is called a selector and allows us to select a value from
// the state. Selectors can also be defined inline where they're used instead of
// in the slice file. For example: `useSelector((state) => state.counter.value)`
export const loaded = (state) => state.hubspotState.loaded;
export const apiKey = (state) => state.hubspotState.apiKey;

// Get hubspot api key
export const fetchHubspotAPIKey = () => (dispatch) => {
  axios
    .post(
      fscs_settings.ajax_url,
      qs.stringify({
        action: "fscs_settings_get_hubspot_api_key_data",
        nonce: fscs_settings.settings_nonce,
        data: []
      })
    )
    .then(({ data }) => {
      dispatch(setLoaded(true));
      dispatch(setAPIKey(data?.api_key));
    });
};

// Save recaptcha values
export const saveHubspotAPIKey =
  ({ values, cb }) =>
  (dispatch) => {
    axios
      .post(
        fscs_settings.ajax_url,
        qs.stringify({
          action: "fscs_settings_save_hubspot_api_key_data",
          nonce: fscs_settings.settings_nonce,
          ...values
        })
      )
      .then(({ data }) => {
        dispatch(setAPIKey(data?.api_key));
        if (typeof cb === "function") cb(data);
      });
  };

export default hubspotSlice.reducer;
