import React from 'react';

import Slider from "react-slick";

class PostsLoop extends React.Component {
  render () {
    let posts = this.props.posts

    let postsBatch = posts.map((post, index)=> {
      return (
        <div key={index} className='go-round__slide'>
          <div className='go-round__img'><img src={post.images.large} /></div>
          <div className='go-round__body'>
            <a className='go-round__title' href={post.link}>
                    <h4>{post.title.rendered}</h4>
            </a>
            <div className='go-round__figure' dangerouslySetInnerHTML={{__html: post.excerpt.rendered}}></div>
          </div>
        </div>
      )
    });

    var settings = {
      dots: true,
      infinite: true,
      speed: 500,
      slidesToShow: 1,
      slidesToScroll: 1
    };

    return (
      <Slider {...settings}>
        {postsBatch}
      </Slider>
      
    )
  }

}

export default PostsLoop;