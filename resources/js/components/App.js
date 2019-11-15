import React, { useEffect } from "react";
import { useDispatch } from "react-redux";
import ReactDOM from "react-dom";
import WeatherBox from "./Weather/WeatherBox";
import Search from "./layout/Search";
import { Provider } from "react-redux";
import { store } from "../redux/reducers";
import { fetchTown } from "../redux/actions";

const App = () => {
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(fetchTown('warsaw'));
    }, []);

    return (
        <div className="row justify-content-center">
            <div className="col-11 align-items-center">
                <Search />
                <WeatherBox />
            </div>
        </div>
    );
};

if (document.getElementById("root")) {
    ReactDOM.render(
        <Provider store={store}>
            <App />
        </Provider>,
        document.getElementById("root")
    );
}
