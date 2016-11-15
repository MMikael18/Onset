import React from 'react';
import ReactDOM from 'react-dom';
import '../sass/styles.scss';

class AddLinkInput extends React.Component {
  constructor(props) {
    super(props);
    this.state = {value: ''};
    //this.handleChange = this.handleChange.bind(this);
  } 
  handleChange(event) {
    this.setState({value: event.target.value});
    this.props.onUrlChange(
      this.refs.filterTextInput.value
    );
  }
  
  handleSubmit(event) {
    alert('A name was submitted: ' + this.state.value);
    event.preventDefault();
  }

  render (){
    return(
      <form onSubmit={e => this.handleSubmit(e)}> 
        <div className="form-group">
          <input 
            type="text" className="form-control"
            placeholder="add url"
            ref="filterTextInput"
            value={this.state.value}
            onChange={e  => this.handleChange(e)} />
        </div>
      </form>
    );
  }
};

/* ----------------------------------------------------------------------- */

class LinkRow extends React.Component{ 
  render (){
    return(
      <li className="list-group-item"><a href={this.props.data.url}>{this.props.data.title}</a></li>
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
    this.onUrlInput = this.onUrlInput.bind(this);
  }

  onUrlInput(value){
    console.log(value);
  }

  componentDidMount() {
      $.ajax({
        url: "/_api",
        dataType: 'json',
        cache: false,
        success: function(d) {
          this.setState({data: d});
        }.bind(this),
        error: function(xhr, status, err) {
          console.error("error", status, err.toString()); 
        }.bind(this)
      });
  }

  
  //componentDidMount
  //componentWillMount

  render() {
    return (
      <div>
        <AddLinkInput onUrlChange={this.onUrlInput} />
        <List data={this.state.data} />
      </div>
    );
  } 
};

//  <List date={this.state.date} />
ReactDOM.render(<App />,document.getElementById('app')); 
