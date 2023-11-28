import { Component } from "react";

class Home extends Component {
  render() {
    return (
      <div>
        <h1>{this.props.text}</h1>
        <span>this is class components</span>
        <p>{this.props.name.data}</p>
        <p>{this.props.address.data}</p>
      </div>
    );
  }
}

export default Home;
