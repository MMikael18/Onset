import React from 'react';
import ReactDOM from 'react-dom';

class AddLinkInput extends React.Component {

  constructor(props) {
    super(props);
    this.state = {        
        url: '',
        title: '',
        description: ''      
    };
  }

  handleChangeUrl(event){
    var value = this.refs.TextInputUrl.value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    if(urlRegex.test(value)){
      this.setState({
        url: value
      });
    }
  }
  handleChangeTitle(event){
    var value = this.refs.TextInputTitle.value;
    this.setState({
        title: value
    });
  }
  handleChangeDescription(event){
      var value = this.refs.TextInputDescription.value;
      this.setState({
       description: value
      });
  }

  handleSubmit(event) {
    event.preventDefault();
    for(var propertyName in this.state) {
      var v = this.state[propertyName];
      if(v.length == 0) return;
    }
    //console.dir(this.state);
    this.props.setNewUrl(
      this.state
    );
  }

  render (){
    return(
      <div>
        <form id="AddLinkInput" className="form-group form-inline" onSubmit={e => this.handleSubmit(e)}>          
            <input
              className="form-control url-input" 
              type="text" 
              placeholder="url"
              ref="TextInputUrl"
              onChange={e => this.handleChangeUrl(e)}
            />          
            <input
              className="form-control url-input" 
              type="text"
              placeholder="title"
              ref="TextInputTitle"
              onChange={e => this.handleChangeTitle(e)}
            />
            <input
              className="form-control url-input" 
              type="text"
              placeholder="description"
              ref="TextInputDescription"
              onChange={e => this.handleChangeDescription(e)}
            />
            <button type="submit" className="btn btn-primary">Add</button>
        </form>        
      </div>
    );
  }
};

export default AddLinkInput;