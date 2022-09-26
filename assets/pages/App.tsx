import React, { useState, useEffect } from 'react';
import Table from 'react-bootstrap/Table';

// repositoryName":"cedaro",
// "ownerName":"better-internal-link-search",
// "trustPoints":256.8,
// "dateCreated":{
//   "date":"2012-01-04 23:11:11.000000",
//   "timezone_type":3,
//   "timezone":"UTC"
// }

type RepositoryData = {
  repositoryName: string
  ownerName: string
  trustPoints: number
  dateCreated: string
}

function App() {
  const [repositories, setRepositories] = useState<RepositoryData[]>([])

  const fetchData = async () => {
    const parameters = new URLSearchParams({
      sort: 'ASC'
    })

    const response = await fetch('http://localhost:8080/api/repositories?' + parameters)
    const data = await response.json()

    setRepositories(data)
  }

  useEffect(() => {
    fetchData()
  }, [])

  // function request<TResponse>(
  //   url: string,
  //   // `RequestInit` is a type for configuring 
  //   // a `fetch` request. By default, an empty object.
  //   config: RequestInit = {}
     
  // // This function is async, it will return a Promise:
  // ): Promise<TResponse> {
      
  //   // Inside, we call the `fetch` function with 
  //   // a URL and config given:
  //   return fetch(url, config)
  //     // When got a response call a `json` method on it
  //     .then((response) => {
  //       return response.json()
  //       console.log(response.json())
  //     })
  //     // and return the result data.
  //     .then((data) => data as TResponse);
      
  //     // We also can use some post-response
  //     // data-transformations in the last `then` clause.
  // }


  return (
    <div>
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>#</th>
            <th>Repository Name</th>
            <th>Owner Name</th>
            <th>Date Created</th>
            <th>Trust Points</th>
          </tr>
        </thead>
        <tbody>
          {
            repositories.map((repository: RepositoryData, index: number) => {
              return <tr key={index}>
                <td>{index}</td>
                <td>{repository.repositoryName}</td>
                <td>{repository.ownerName}</td>
                <td>{repository.dateCreated}</td>
                <td>{repository.trustPoints}</td>
              </tr>
            })
          }
        </tbody>
      </Table>
    </div>
  );
}

export default App;