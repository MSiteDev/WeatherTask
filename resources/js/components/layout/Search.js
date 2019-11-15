import React, { Component } from "react";
import AsyncCreatableSelect from 'react-select/async-creatable';
import {connect} from "react-redux";
import {findPlace, searchPlaces} from "../../redux/actions";

class Search extends Component{

    loadOptions = (inputValue, callback) => {

        this.props.searchPlaces(inputValue);
        setTimeout(() => {
            callback(this.props.options);
        }, 0);


    };

    handleSelect = selectedOption => {

        if(selectedOption.__isNew__)
            this.props.findPlace(selectedOption.value);
        else
            this.props.findPlace(selectedOption.value);
    };

    formatOptionLabel = ({value, label}) => {
        return (
            <div>
                {label}
            </div>
        )
    };

    render()
    {
        return (
            <div className='mt-2 mb-2'>
                <AsyncCreatableSelect
                    isClearable={true}
                    loadOptions={this.loadOptions}
                    formatOptionLabel={this.formatOptionLabel}
                    onChange={this.handleSelect}
                    placeholder='Wprowadź nazwę miasta'
                />
            </div>
        );
    }
}

const mapStateToProps = state => {
    return {
        options: state.places.list.map(item => {
            item.label = item.name;
            item.value = item.id;
            return item;
        })
    }
};

const mapDispatchToProps = {searchPlaces, findPlace};

export default connect(mapStateToProps, mapDispatchToProps)(Search);
