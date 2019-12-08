import React, { Component } from 'react';

//import Getposts from './obtaindata';
import PostsLoop from './postsloop';

class PostsMount extends Component {

  constructor () {
    super();
    this.state = {
      slides: []
    }
 
  }

  componentDidMount (){

    const catUrl = RPC_CAT_url;

    fetch(catUrl)
    .then(response => response.json())
    .then(response => {
      this.setState({
        slides: response
      })
    })
  }
 
  render() {

    
    return (

      <div className="go-round__container">
        
          <PostsLoop posts={this.state.slides} />
         
      </div>

    );
  }
}

export default PostsMount;