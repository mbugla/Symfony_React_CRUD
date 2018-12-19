import React, { Component } from 'react';

class Success extends Component {
      
    render () {
      return (
          <div className="alert alert-success alert-dismissible fade show" role="alert"><b>{this.props.message}</b></div>
      )
    }
  }

export default Success