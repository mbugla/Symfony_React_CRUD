import React, { Component } from 'react';
import axios from 'axios';
import { withRouter, Link } from 'react-router-dom';
import Error from './errors.component';
import Success from './success.component';
import LoadingSpinner from './loadingSpinner.component';

class Create extends Component {
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
          isLoading: false,
          success: false
      }
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
    this.setState({
        isLoading: true
    })

    e.preventDefault();
    const obj = {
      name: this.state.name,
      surname: this.state.surname,
      telephoneNumber: this.state.telephoneNumber,
      address: this.state.address
    };
    try {
        await axios.post('http://localhost:81/users', obj);
        this.setState({
            name: '',
            surname: '',
            telephoneNumber: '',
            address: '',
            isLoading: false,
            success: true,
            errors: null
          });

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
        return <Success message={ 'User created. Redirecting to users list.' } />;
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
              <h3>Add User</h3>
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
                      <input type="submit" value="Create" className="btn btn-primary"/>
                      <Link to={ '/index' } className="btn btn-cancel">Cancel</Link>
                  </div>
              </form>
          </div>
      )
     }
  }
}

export default withRouter(Create)