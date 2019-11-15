import React, { Component } from "react";
import { TiWeatherCloudy } from "react-icons/ti";
import { FaTemperatureHigh, FaWind, FaLongArrowAltUp } from "react-icons/fa";
import { IoIosWater } from "react-icons/io";
import { GiRoundKnob } from "react-icons/gi";
import {connect} from "react-redux";

class WeatherBox extends Component
{
    render() {

        const { place } = this.props;

        const weather = place ? place.current_weather : {};

        return Object.keys(place).length ? (
            <div className="card">
                <div className="card-header">Aktualna pogoda dla {place.name} ({place.country_code})</div>
                <div className="card-body">
                    <div style={{ textAlign: "center" }}>
                        <img src={"http://openweathermap.org/img/wn/" + weather.icon + "@2x.png"} alt="WeatherIcon"/>
                        <h1 className="weather-header">{weather.name}</h1>
                        <div className="weather-temp">
                            <h4>{weather.temperature || "0"} °C</h4>
                        </div>
                    </div>
                    <div className="weather">
                        <div className="row">
                            <div className="col-12 col-md-6 col-xl-3">
                                <div className="weather-block bg-primary">
                                    <h5 className="text-light">Odczuwalna</h5>
                                    <div className="d-flex flex-row">
                                        <h5 className="mr-2 text-light">Brak danych</h5>
                                        <FaTemperatureHigh
                                            color="white"
                                            size="1.5rem"
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="col-12 col-md-6 col-xl-3">
                                <div className="weather-block bg-success">
                                    <h5 className="text-light">
                                        Wilgotność powietrza
                                    </h5>
                                    <div className="d-flex flex-row">
                                        <h5 className="mr-2 text-light">{weather.humidity}%</h5>
                                        <IoIosWater color="white" size="1.5rem" />
                                    </div>
                                </div>
                            </div>
                            <div className="col-12 col-md-6 col-xl-3">
                                <div className="weather-block bg-warning">
                                    <h5>Ciśnienie</h5>
                                    <div className="d-flex flex-row">
                                        <h5 className="mr-2">{weather.pressure} hPa</h5>
                                        <GiRoundKnob size="1.5rem" />
                                    </div>
                                </div>
                            </div>
                            <div className="col-12 col-md-6 col-xl-3">
                                <div className="weather-block bg-info">
                                    <h5 className="text-light">Wiatr</h5>
                                    <div className="d-flex flex-row">
                                        <h5 className="mr-2 text-light">{weather.wind_speed} m/s</h5>
                                        <FaLongArrowAltUp
                                            color="white"
                                            size="1.5rem"
                                            style={{transform: "rotate(-" + weather.wind_degree + "deg)"}}
                                        />
                                    </div>
                                </div>
                            </div>
                            <div className="col-12">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ) : (
            <h1>Wprowadź miasto</h1>
        );
    }
}

const mapStateToProps = state => {
    return {
        place: state.places.current
    }
};

export default connect(mapStateToProps)(WeatherBox);
