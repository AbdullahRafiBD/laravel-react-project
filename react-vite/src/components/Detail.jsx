import axios from "axios";
import { useEffect, useState } from "react";
import { Link, useNavigate, useSearchParams } from "react-router-dom";

const Detail = () => {
  let user = JSON.parse(localStorage.getItem("user"));
  const [userid, setUserid] = useState(user.userDetails.id);

  const [product, setProduct] = useState([]);
  const [searchParams, setSearchParams] = useSearchParams();
  const [size, setSize] = useState("");
  const [productid, setProductid] = useState("");
  const navigate = useNavigate();

  const fetchData = () => {
    return axios
      .get("http://127.0.0.1:8000/api/detail/" + searchParams.get("id"))
      .then((response) => setProduct(response.data["product"]));
  };

  async function addtoCart() {
    // alert("test");
    var size = searchParams.get("size");
    var productid = searchParams.get("id");
    // alert(size);
    // alert(productid);
    // alert(userid);
    let item = { size, productid, userid };
    // console.warn(item);
    let result = await fetch("http://127.0.0.1:8000/api/add-to-cart", {
      method: "POST",
      headers: { "Content-type": "application/json" },
      body: JSON.stringify(item),
    });
    result = await result.json();
    // console.warn(result);

    // check product is already exists in the User Cart
    if (result["message"] == "Product Already Exists In Cart!") {
      alert(result["message"]);
    } else if (result["message"] == "Product Added Sucessfully!") {
      alert(result["message"]);
      navigate("/cart");
    }
  }

  useEffect(() => {
    fetchData();
  }, []);

  return (
    <div align="center">
      {product.map((productObj) => {
        return (
          <div key={productObj.id}>
            <h3>{productObj.product_name}</h3>
            <img src={productObj.product_image} />
            <h4>Code: {productObj.product_code}</h4>
            <h4 style={{ color: "red" }}>Price: {productObj.final_price}</h4>
            <h4>
              {productObj.brand.name}/{" "}
              <Link to={"/listing?url=" + productObj.category.url}>
                {productObj.category.category_name}
              </Link>
            </h4>

            <h5 style={{ color: "blue" }}>
              {productObj.product_short_description}
            </h5>
            {/* Condition Login or not */}
            {localStorage.getItem("user") ? (
              <>
                {/* Condition to Proceed to Checkout */}
                {searchParams.get("size") ? (
                  <form action="javascript:;">
                    <input
                      name="userid"
                      type="hidden"
                      value={userid}
                      onChange={(e) => setUserid(e.target.value)}
                    />
                    <input
                      name="id"
                      type="hidden"
                      value={productObj.id}
                      onChange={(e) => setProductid(e.target.value)}
                    />
                    <input
                      name="size"
                      type="hidden"
                      value={searchParams.get("size")}
                      onChange={(e) => setSize(e.target.value)}
                    />

                    <h5>Selected Sizes: {searchParams.get("size")}</h5>
                    <button onClick={addtoCart} className="btn btn-primary">
                      Checkout
                    </button>
                  </form>
                ) : (
                  <form action="">
                    <input
                      name="id"
                      type="hidden"
                      value={productObj.id}
                      onChange={(e) => setProductid(e.target.value)}
                    />

                    <h5>
                      Sizes:
                      <select name="size">
                        {productObj.attributes.map((valObj) => {
                          return (
                            <option key={valObj.size} value={valObj.size}>
                              {valObj.size}
                            </option>
                          );
                        })}
                      </select>
                    </h5>
                    <button className="btn btn-primary">Proceed</button>
                  </form>
                )}
              </>
            ) : (
              <Link to={"/login"}>
                <button className="btn btn-primary">Login to checkout</button>
              </Link>
            )}
          </div>
        );
      })}
    </div>
  );
};

export default Detail;
