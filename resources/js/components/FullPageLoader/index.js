import React from "react";
import Spenner from "../../../images/Infinity-1s-200px.gif";
const FullPageLoader = () => {
    return (
        <div className="fp-container">
            <img src={Spenner} className="fp-loader" alt="loading" />
        </div>
    );
};

export default FullPageLoader;
