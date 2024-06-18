import React, { useEffect, useState } from 'react'
import { Link, Head } from '@inertiajs/react'
import axios from 'axios'

const Fundraisers = () => {
  const [data, setData] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)

  useEffect(() => {
    const fetchFundraisers = async () => {
      try {
        const response = await axios.get('/api/fundraisers')
        console.log(response.data)

        // Check if response data is an array
        if (Array.isArray(response.data.fundraisers)) {
          setData(response.data)
        } else {
          throw new Error('Invalid data format')
        }
      } catch (err) {
        setError('Failed to fetch fundraisers')
      } finally {
        setLoading(false)
      }
    }

    fetchFundraisers()
  }, [])

  if (loading) {
    return <div>Loading...</div>
  }

  if (error) {
    return <div>{error}</div>
  }

  return (
    <>
      <Head title="Fundraisers" />
      <div className="container">
        <h1>Fundraisers</h1>
        {data.fundraisers.length === 0
          ? (
          <p>No fundraisers available.</p>
            )
          : (
              data.fundraisers.map((fundraiser) => (
            <div key={fundraiser.id} className="card">
              <h2>{fundraiser.name}</h2>
              <p>Goal: {fundraiser.goal_amount} {fundraiser.currency}</p>
              <p>Deadline: {new Date(fundraiser.deadline).toLocaleDateString()}</p>
              <p>Missions: {fundraiser.missions_count}</p>
              <p>Total Raised: {fundraiser.total_raised} / {fundraiser.goal_amount} {fundraiser.currency}</p>
              {fundraiser.missions_count > 0 && (
                <Link href={`/fundraisers/${fundraiser.id}`}>View Missions</Link>
              )}
            </div>
              ))
            )}
      </div>
    </>
  )
}

export default Fundraisers
