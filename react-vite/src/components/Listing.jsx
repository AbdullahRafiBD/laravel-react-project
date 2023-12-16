import axios from "axios";
import { useEffect, useState } from "react";
// import { BrowserRouter as Router, Link, Route } from "react-router-dom";
import { useSearchParams } from "react-router-dom";

const Listing = () => {
  const [products, setProducts] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/listing/" + searchParams.get("url"))
      .then((response) => setProducts(response.data["products"]));
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div align="center">
      {products.map((productObj) => {
        return (
          <div key={productObj.id}>
            <h3>{productObj.product_name}</h3>
            <img src={productObj.product_image} />
            <h3>Price:{productObj.product_price}</h3>
            <hr />
          </div>
        );
      })}
    </div>
  );
};

export default Listing;
