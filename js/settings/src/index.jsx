import App from "./App";
import { render } from "@wordpress/element";
import { Provider } from "react-redux";
import store from "./store";

/**
 * Import the stylesheet for the plugin.
 */
import "../style/main.scss";

// Render the App component into the DOM
render(
  <Provider store={store}>
    <App />
  </Provider>,
  document.getElementById("fuel-savings-settings")
);
