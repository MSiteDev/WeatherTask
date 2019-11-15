import { createStore, applyMiddleware, combineReducers } from "redux";
import { composeWithDevTools } from "redux-devtools-extension";
import thunk from "redux-thunk";
import {FIND_CITY, SEARCH_SUCCESS, FINDING_SUCCESS, FINDING_FAILED} from "../types";

const placesInitialState = {
    current: {},
    list: []
};

export const places = (state = placesInitialState, action) => {
    switch (action.type) {
        case FIND_CITY:
            return Object.assign({}, state, action.payload);
        case SEARCH_SUCCESS:
            return Object.assign({}, state, {list: action.payload});
        case FINDING_SUCCESS:
            return Object.assign({}, state, {current: action.payload});
        case FINDING_FAILED:
            return Object.assign({}, state, {current: {}});
        default:
            return state;
    }
};

const reducers = combineReducers({
    places
});

export const store = createStore(
    reducers,
    composeWithDevTools(applyMiddleware(thunk))
);
