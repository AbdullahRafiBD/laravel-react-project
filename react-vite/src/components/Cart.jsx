import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useSearchParams } from "react-router-dom";

const Cart = () => {
  const [products, setProducts] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/cart/" + searchParams.get("userid"))
      .then((response) => setProducts(response.data["products"]));
  };

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div align="center">
      <h2>Shopping Cart</h2>
      {products.map((productObj) => {
        return (
          <div key={productObj.id}>
            <h3>{productObj.product.product_name}</h3>
            <Link to={"/detail?id=" + productObj.id}>
              <img src={productObj.product.product_image} />
            </Link>
            <h3>Price:{productObj.product.product_price}</h3>
            <Link to={"/delete-cart-item?cartid=" + productObj.id}>
              <button type="button" className="close" aria-label="Close">
                <span aria-hidden="true">Delete</span>
              </button>
            </Link>
            <hr />
          </div>
        );
      })}
      <Link to={"/shop"}>
        <button className="btn btn-info">Continue Shopping</button>
      </Link>
      <br /> <br />
      <button className="btn btn-primary">Proceed</button>
    </div>
  );
};

export default Cart;
