import React, { Component } from 'react';

class Error extends Component {
      
    render () {
      return (
          <div className="alert alert-danger alert-dismissible fade show" role="alert"><b>{this.props.obj.property}</b>: {this.props.obj.message}</div>
      )
    }
  }

export default Error