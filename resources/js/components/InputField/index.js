import React, { useState } from "react";
import PropTypes from "prop-types";
import { FormGroup } from "reactstrap";
import { validateInput } from "../../utilities/Validator";

const InputField = ({
    value,
    label,
    placeholder,
    validators,
    type,
    onChange,
}) => {
    const [error, setError] = useState(false);

    const handleChange = (event) => {
        const { value } = event;
        setError(validateInput(validators, value));
        onChange(value);
    };

    return (
        <FormGroup>
            {label && <label htmlFor="app-input-field">{label}</label>}

            {type === "textarea" ? (
                <textarea
                    className="form-control"
                    placeholder={placeholder}
                    value={value}
                    defaultValue={value}
                    onChange={(e) => {
                        handleChange(e.target);
                    }}
                />
            ) : (
                <input
                    type={type}
                    value={value}
                    className="form-control"
                    placeholder={placeholder}
                    onChange={(e) => {
                        handleChange(e.target);
                    }}
                />
            )}
            {error && <span className="text-danger">{error.message}</span>}
        </FormGroup>
    );
};

InputField.propTypes = {
    value: PropTypes.string,
    label: PropTypes.string,
    placeholder: PropTypes.string,
    validators: PropTypes.array,
    type: PropTypes.string,
    onChange: PropTypes.func.isRequired,
};

InputField.defaultProps = {
    value: "",
    label: "",
    placeholder: "",
    type: "text",
    validators: [],
};

export default InputField;
