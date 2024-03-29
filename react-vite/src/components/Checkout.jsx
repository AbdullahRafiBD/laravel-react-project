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

      <h2>Delivery Address</h2>
      <div className="col-sm-6">
        <input type="text" placeholder="Enter Name" className="form-control" />{" "}
        <br />
        <input
          type="text"
          placeholder="Enter Address"
          className="form-control"
        />
        <br />
        <input type="text" placeholder="Enter City" className="form-control" />
        <br />
        <input type="text" placeholder="Enter State" className="form-control" />
        <br />
        <input
          type="text"
          placeholder="Enter Country"
          className="form-control"
        />
        <br />
        <input
          type="text"
          placeholder="Enter Pincode"
          className="form-control"
        />
        <br />
        <input
          type="text"
          placeholder="Enter Mobile"
          className="form-control"
        />
        <br />
        <Link to={"/cart?userid=" + searchParams.get("userid")}>
          <button className="btn btn-info">Back to Cart</button>
        </Link>
        <br /> <br />
        <Link>
          <button className="btn btn-warning">Place Order</button>
        </Link>
      </div>
    </div>
  );
};

export default Checkout;
