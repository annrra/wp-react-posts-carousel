import React from 'react';
import ReactDOM from 'react-dom';

//import PostsLoop from './postsloop';
import PostsMount from './postsmount';

ReactDOM.render(<PostsMount />, document.getElementById('go-round'));

module.hot.accept();