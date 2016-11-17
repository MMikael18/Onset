/*
<div  className="form-control url-input"  
onInput = {e  => this.handleChange(e)} 
onBlur  = {e  => this.handleChange(e)}
onKeyUp={e  => this.handleChange(e)}
ref="urlinput"
id="editable"
dangerouslySetInnerHTML = {{__html: this.state.html}}
contentEditable="true">
</div>
*/
import React from 'react';
import ReactDOM from 'react-dom';
import '../sass/styles.scss';

class AddLinkInput extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
        url: 'url',
        title: 'title',
        description: 'description',
        tags: 'tags'
    };
    //this.handleChange = this.handleChange.bind(this);
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

  handleChange(event){

  }
  
  handleSubmit(event) {
    alert('A name was submitted: ');
    event.preventDefault();
  }

  render (){
    return(
      <div>
        <form id="AddLinkInput" className="form-group" onSubmit={this.handleSubmit}>
          <input
              className="form-control url-input" 
              type="text"
              placeholder="url"
              value={this.props.filterText}
              ref="filterTextInput"
              onChange={this.handleChange}
            />
        </form>
        {this.state.url}
      </div>
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
        url: "/_api/links//5",
        dataType: 'json',
        cache: false,
        success: function(d) {
          console.dir(d);
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
        <AddLinkInput onUrlChange={this.onUrlInput} />
        <List data={this.state.data} />
      </div>
    );
  } 
};

//  <List date={this.state.date} />
ReactDOM.render(<App />,document.getElementById('app')); 
