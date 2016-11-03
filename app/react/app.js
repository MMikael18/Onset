import React from 'react';
import ReactDOM from 'react-dom';

var Main = React.createClass({
  render: function() {
    return(
      <div>React</div>
    )
  }
});

ReactDOM.render(
  <Main />,
  document.getElementById('app')
)
