import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useSearchParams } from "react-router-dom";

const Checkout = () => {
  const [products, setProducts] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/checkout/" + searchParams.get("userid"))
      .then((response) => setProducts(response.data["products"]));
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div align="center">
      <h2>Checkout Cart</h2>
      {products.map((productObj) => {
        return (
          <div key={productObj.id}>
            <h3>{productObj.product.product_name}</h3>
            <Link to={"/detail?id=" + productObj.id}>
              <img src={productObj.product.product_image} />
            </Link>
            <h3>Price:{productObj.product.product_price}</h3>
            <hr />
          </div>
        );
      })}

      {products.map((productObj) => {
        return (
          <div key={productObj.id}>
            {productObj.product.key === 0 ? (
              <h4>total Price: {productObj.product.total_price}</h4>
            ) : null}
          </div>
        );
      })}
    </div>
  );
};

export default Checkout;
