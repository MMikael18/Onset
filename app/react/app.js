import React from 'react';
import ReactDOM from 'react-dom';
import './styles.scss';

var LinkRow = React.createClass({ 
  render: function(){
    return(
      <li className="list-group-item"><a href={this.props.data.url}>{this.props.data.title}</a></li>
    );
  }
});

var Collapsible = React.createClass({
  render: function() {
    
    var rows = [];
    var num = 0;
    this.props.data.forEach(function(c) {
      rows.push(<LinkRow key={c.id} data={c}  />);
    });
    
    return (
      <ul className="list-group">
        {rows}
      </ul>
    );
  }
});

var App = React.createClass({
  getInitialState: function() {
    return {data: []};
  },
  componentDidMount: function(){
    $.ajax({
      url: "/_api",
      dataType: 'json',
      cache: false,
      success: function(data) {
        console.dir(data);
        this.setState({data: data});
      }.bind(this),
      error: function(xhr, status, err) {
        console.error("error", status, err.toString()); 
      }.bind(this)
    });
  },
  hadleOnChange: function(d){
    this.setState({data: d});
  },  
  render: function() {
    return (
      <div>
        <Collapsible data={this.state.data} />
      </div>
    );
  } 
});

ReactDOM.render(<App />,document.getElementById('app')); 
