import React, { useState } from "react";
import FullPageLoader from "../components/FullPageLoader";
const useFullPageLoader = () => {
    const [loading, setloading] = useState(false);
    return [
        loading ? <FullPageLoader /> : null,
        () => setloading(true), //show loading
        () => setloading(false), // hide loading
    ];
};

export default useFullPageLoader;
