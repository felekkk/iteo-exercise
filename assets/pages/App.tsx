import React, { useState, useEffect } from 'react';
import Table from 'react-bootstrap/Table';
import { BsFillArrowDownCircleFill, BsFillArrowUpCircleFill } from "react-icons/bs";

type RepositoryData = {
  repositoryName: string
  ownerName: string
  trustPoints: number
  dateCreated: string
}

function App() {
  const [repositories, setRepositories] = useState<RepositoryData[]>([])
  const [sort, setSort] = useState<string>('DESC')

  const fetchData = async () => {
    const parameters = new URLSearchParams({
      sort: sort
    })

    const response = await fetch('http://localhost:7777/api/repositories?' + parameters)
    const data = await response.json()

    setRepositories(data)
  }

  useEffect(() => {
    fetchData()
  }, [sort])

  const sortButton = () => {
    if (sort === 'DESC') {
      return <BsFillArrowDownCircleFill onClick={() => setSort('ASC')}/>
    }
    
    return <BsFillArrowUpCircleFill onClick={() => setSort('DESC')}/>
  }

  return (
    <div>
      <Table striped bordered hover>
        <thead>
          <tr>
            <th>#</th>
            <th>Owner Name</th>
            <th>Repository Name</th>
            <th>
              {sortButton()}Date Created
            </th>
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