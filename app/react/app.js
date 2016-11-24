import React from 'react';
import ReactDOM from 'react-dom';
import AddLinkInput from './addLinkInput';
import '../sass/styles.scss';

/* ----------------------------------------------------------------------- */

class LinkRow extends React.Component{ 
  render (){
    /*
    var tags = [];
    this.props.data.tags.forEach((t) => {
      tags.push(<span key={t} className="tag tag-success">{t}</span> );
    });
    */
    return(
      <li className="list-group-item">
        <span>
          <small>{this.props.data.date}</small> - <a href={"//"+this.props.data.url} target="_blank">{this.props.data.title}</a><br/>
          <small>{this.props.data.url}</small>
        </span>
        <span>{this.props.data.description}</span>
        <span className="tags"></span>     
      </li>
    );
  }
};

class List extends React.Component {

  render () {
    var rows = [];
    this.props.data.forEach((c) => {
      rows.push(<LinkRow key={c.id} data={c}  />);
    });
  
    return (
      <ul className="list-group">
        {rows}
      </ul>
    );
  }

};

/* ----------------------------------------------------------------------- */

class App extends React.Component{

  constructor(props) {
    super(props);
    this.state = {data: []};
    this.setNewUrl = this.setNewUrl.bind(this);
  }

  setNewUrl(value){
    $.post("/_api/links/setLink/", {data:value}).done(function( data ) {
      console.dir(data);
      console.log("data");
    });
  }

  componentDidMount() {
      $.ajax({
        url: "/_api/links/getLinks/5",
        dataType: "json",
        cache: false,
        success: function(d) {
          this.setState({data: d});
        }.bind(this),
        error: function(xhr, status, err) {
          console.error("error", status, err.toString()); 
        }.bind(this)
      });
  }

  render() {
    return (
      <div>
        <AddLinkInput setNewUrl={this.setNewUrl} />
        <List data={this.state.data} />
      </div>
    );
  } 
};

//  <List date={this.state.date} />
ReactDOM.render(<App />,document.getElementById('app')); 
