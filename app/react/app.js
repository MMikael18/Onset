import React from 'react';
import ReactDOM from 'react-dom';
import '../sass/styles.scss';

class AddLinkInput extends React.Component {

  constructor(props) {
    super(props);
    this.state = {
        class: 'form-control url-input',
        url: '',
        title: '',
        description: ''
    };
    this.class = {
      succes: 'form-control url-input form-control-succes',
      warning: 'form-control url-input form-control-warning',
      danger: 'form-control url-input form-control-danger'
    }
  }

  handleChangeEdit(e) {

    var editableDiv = document.getElementById('editable'); 

    var caretPos = 0,
        line = 0,
    sel, range;
    sel = window.getSelection();
    range = sel.getRangeAt(0);
    if (range.commonAncestorContainer.parentNode == editableDiv) {
        caretPos = range.endOffset;
        line = range.commonAncestorContainer.parentNode;
    }

    if (e.keyCode === 0 || e.keyCode === 32) {
      e.preventDefault()
      //console.log('Space pressed')

      var html = this.refs.urlinput.innerHTML;
      var urlRegex = /(^|\s)(https?:\/\/[^\s]+)(^|\s)/g;
      if(urlRegex.test(html)){
        this.refs.urlinput.innerHTML = html.replace(urlRegex, function(url) {
            return ' <a href="' + url.trim() + '">' + url.trim() + '</a> ';
        })
        
        if (line) {
            range = range.cloneRange();
            range.setStartAfter(line,1);
            range.collapse(true);
            sel.removeAllRanges();
            sel.addRange(range);
        }
      }
    }

    //this.setState({html: html});
    /*
    this.props.onUrlChange(
      this.refs.filterTextInput.value
    );
    */
  }


  handleChangeUrl(event){
    var value = this.refs.TextInputUrl.value;
    var urlRegex = /(https?:\/\/[^\s]+)/g;
    if(urlRegex.test(value)){
      this.setState({
        url: value
      });
    }else{
      this.setState({
        class: this.class.danger
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
    console.log("ok");
    /*
    this.props.setNewUrl(
      this.refs.urlTextInput.value
    );
    */
    
  }

  render (){

    return(
      <div>
        <form id="AddLinkInput" className="form-group form-inline" onSubmit={e => this.handleSubmit(e)}>          
            <input
              className={this.state.class}
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
    var item = {}
    console.log(value);
  }

  componentDidMount() {
      $.ajax({
        url: "/_api/links/getLinks/5",
        dataType: 'json',
        cache: false,
        success: function(d) {
          //console.dir(d);
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
