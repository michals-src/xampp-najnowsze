import React from "react";
import "./App.css";

class App extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            data: []
        }
    }

    componentDidMount(){
        return fetch('http://localhost/wp-json/wp/v2/posts')
        .then((response) => response.json())
        .then((responseJson) => {
            this.setState({data: responseJson});
        })
        .catch((error) => {
            console.log(error);
        });
    }

    render(){
        if(this.state.data.length <= 0) return null;
        return(
            <div>
                {this.state.data.map((post,index)=>(
                    <h3 key={index}>{post.title.rendered}</h3>
                ))}
            </div>
        );
    }
}

export default App;
