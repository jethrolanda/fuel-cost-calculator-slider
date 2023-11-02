import { createSlice } from '@reduxjs/toolkit'
import axios from '../../helpers/axios';
const qs = require("qs");

// Recaptcha state
export const homeSlice = createSlice({
  name: 'homeState',
  initialState: {
    loaded: false,
    fuel_savings_data: '',
    pagination: {
      total: 0,
      pageSize: 10,
      current: 1
    }
  },
  reducers: {
    setLoaded: (state, action) => {
      state.loaded = action.payload;
    },
    setData: (state, action) => {
      state.fuel_savings_data = action.payload;
    },
    setPagination: (state, action) => {
      state.pagination = {...state.pagination, ...action.payload };
    },
  },
})

export const { setLoaded, setData, setPagination } = homeSlice.actions

// The function below is called a selector and allows us to select a value from
// the state. Selectors can also be defined inline where they're used instead of
// in the slice file. For example: `useSelector((state) => state.counter.value)`
export const loaded = (state) => state.homeState.loaded
export const fuel_savings_data = (state) => state.homeState.fuel_savings_data
export const pagination = (state) => state.homeState.pagination

// Get recaptcha values
export const fetchFuelSavingsData = ({cb}) => (dispatch) => {
  
  axios.post(fscs_settings.ajax_url, qs.stringify({
    action: "fscs_get_fuel_savings_data",
    nonce: fscs_settings.settings_nonce,
    data: []
  })).then(({data}) => {
    dispatch(setLoaded(true));
    dispatch(setData(data?.data));
    dispatch(setPagination({...data?.pagination}));
    if (typeof cb === "function") cb(data);
  });
  
}

export default homeSlice.reducer