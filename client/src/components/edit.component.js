import React, { Component } from 'react';
import axios from 'axios';
import { withRouter, Link } from 'react-router-dom';
import Error from './errors.component';
import Success from './success.component';
import LoadingSpinner from './loadingSpinner.component';

class Edit extends Component {
  constructor(props) {
      super(props);
      this.onChangeName = this.onChangeName.bind(this);
      this.onChangeSurname= this.onChangeSurname.bind(this);
      this.onChangeTelephoneNumber = this.onChangeTelephoneNumber.bind(this);
      this.onChangeAddress = this.onChangeAddress.bind(this);

      this.onSubmit = this.onSubmit.bind(this);

      this.state = {
          name: '',
          surname: '',
          telephoneNumber:'',
          address: '',
          errors: null,
          sucess: false,
          isLoading: true
      }
  }

  componentDidMount() {
    axios.get('http://localhost:81/users/'+this.props.match.params.id)
        .then(response => {
            this.setState({ 
                name: response.data.name,
                surname: response.data.surname,
                telephoneNumber:response.data.telephoneNumber,
                address: response.data.address,
                isLoading: false
            });
        })
        .catch(function (error) {
            console.log(error);
        })
    }

  onChangeName(e) {
    this.setState({
      name: e.target.value
    });
  }
  onChangeSurname(e) {
    this.setState({
      surname: e.target.value
    })  
  }
  onChangeTelephoneNumber(e) {
    this.setState({
      telephoneNumber: e.target.value
    })
  }
  onChangeAddress(e) {
    this.setState({
      address: e.target.value
    })
  }

  async onSubmit(e) {
    e.preventDefault();
    const obj = {
      name: this.state.name,
      surname: this.state.surname,
      telephoneNumber: this.state.telephoneNumber,
      address: this.state.address
    };
        this.setState({
            isLoading: true
        })
        try {
            await axios.put('http://localhost:81/users/'+this.props.match.params.id, obj)
            this.setState({
                name: '',
                surname: '',
                telephoneNumber: '',
                address: '',
                success: true,
                errors: null,
                isLoading: false
              })
            
            setTimeout(()=>{
                this.props.history.push('/index')
            }, 3000);
            
        } catch(error) {
            const errorObject=JSON.parse(JSON.stringify(error));
            this.setState({
                isLoading: false,
                errors: errorObject.response.data
            });
        }
  }

  renderMessages = () => {
    if(this.state.errors) {
        return this.state.errors.map(function(object, i){
            return <Error obj={ object } key={ i } />;
        });
    }
    if(this.state.success) {
        return <Success message={ 'User data edited. Redirecting to users list.' } />;
    }
  };

  render() {
      if(this.state.isLoading) {
         return ( <LoadingSpinner/>)
      } else {
        return (
            <div style={ { marginTop: 10 } }>
                <div id="messages">
                    {this.renderMessages()}
                </div>
                <h3>Edit User</h3>
                <form onSubmit={ this.onSubmit }>
                    <div className="form-group">
                        <label>Name:  </label>
                        <input 
                          type="text" 
                          className="form-control" 
                          value={ this.state.name }
                          onChange={ this.onChangeName }
                          />
                    </div>
                    <div className="form-group">
                        <label>Surname: </label>
                        <input type="text" 
                          className="form-control"
                          value={ this.state.surname }
                          onChange={ this.onChangeSurname }
                          />
                    </div>
                    <div className="form-group">
                        <label>Telephone Number: </label>
                        <input type="text" 
                          className="form-control"
                          value={ this.state.telephoneNumber }
                          onChange={ this.onChangeTelephoneNumber }
                          />
                    </div>
                    <div className="form-group">
                        <label>Address: </label>
                        <input type="text" 
                          className="form-control"
                          value={ this.state.address }
                          onChange={ this.onChangeAddress }
                          />
                    </div>
                    <div className="form-group">
                        <input type="submit" value="Update" className="btn btn-primary"/>
                        <Link to={ '/index' } className="btn btn-cancel">Cancel</Link>
                    </div>
                </form>
            </div>
        )
      }  
  }
}

export default withRouter(Edit);