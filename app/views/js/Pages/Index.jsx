import React, { useEffect, useState } from 'react'
import { Head } from '@inertiajs/react'
import axios from 'axios'

const Fundraisers = () => {
  const [fundraisers, setFundraisers] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)
  const [page, setPage] = useState(1)
  const [totalPages, setTotalPages] = useState(1)

  useEffect(() => {
    const fetchFundraisers = async () => {
      try {
        const response = await axios.get(`/api/fundraisers?page=${page}`)
        setTotalPages(response.data._pages.total ?? 1)

        if (response.data && Array.isArray(response.data.fundraisers)) {
          const updatedFundraisers = await Promise.all(response.data.fundraisers.map(async (fundraiser) => {
            try {
              const missionsResponse = await axios.get(`/api/fundraisers/${fundraiser.id}/missions`)
              if (missionsResponse.data && Array.isArray(missionsResponse.data.missions)) {
                fundraiser.missions = await Promise.all(missionsResponse.data.missions.map(async (mission) => {
                  try {
                    const donationsResponse = await axios.get(`/api/fundraisers/${fundraiser.id}/missions/${mission.id}/donations`)
                    if (donationsResponse.data && Array.isArray(donationsResponse.data.donations)) {
                      mission.donations = donationsResponse.data.donations
                    } else {
                      mission.donations = []
                    }
                    mission.donations_count = mission.donations.length
                    mission.total_raised = mission.donations.reduce((total, donation) => total + donation.amount, 0)
                  } catch (donationsError) {
                    if (donationsError.response && donationsError.response.status === 404) {
                      mission.donations = []
                      mission.donations_count = 0
                      mission.total_raised = 0
                    } else {
                      throw donationsError
                    }
                  }
                  return mission
                }))
              } else {
                fundraiser.missions = []
              }
            } catch (missionsError) {
              if (missionsError.response && missionsError.response.status === 404) {
                fundraiser.missions = []
              } else {
                throw missionsError
              }
            }
            fundraiser.missions_count = fundraiser.missions.length
            fundraiser.total_raised = fundraiser.missions.reduce((total, mission) => total + mission.total_raised, 0)
            return fundraiser
          }))
          setFundraisers(updatedFundraisers)
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
  }, [page])

  const toggleMissions = (fundraiserId) => {
    const updatedFundraisers = fundraisers.map((fundraiser) => {
      if (fundraiser.id === fundraiserId) {
        fundraiser.showMissions = !fundraiser.showMissions
      }
      return fundraiser
    })
    setFundraisers(updatedFundraisers)
  }

  const toggleDonations = async (fundraiserId, missionId) => {
    const updatedFundraisers = await Promise.all(
      fundraisers.map(async (fundraiser) => {
        if (fundraiser.id === fundraiserId) {
          fundraiser.missions = await Promise.all(
            fundraiser.missions.map(async (mission) => {
              if (mission.id === missionId) {
                mission.showDonations = !mission.showDonations
                if (mission.showDonations && !mission.donorsFetched) {
                  mission.donations = await Promise.all(
                    mission.donations.map(async (donation) => {
                      try {
                        const donorResponse = await axios.get(`/api/employees/${donation.employee_id}`)
                        donation.donor = donorResponse.data
                      } catch (donorError) {
                        donation.donor = { first_name: 'Unknown', last_name: '', email: '' }
                      }
                      return donation
                    })
                  )
                  mission.donorsFetched = true
                }
              }
              return mission
            })
          )
        }
        return fundraiser
      })
    )
    setFundraisers(updatedFundraisers)
  }

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
        {fundraisers.length === 0
          ? (
          <p>No fundraisers available.</p>
            )
          : (
              fundraisers.map((fundraiser) => (
            <div key={fundraiser.id} className="card">
              <h2 onClick={() => toggleMissions(fundraiser.id)} style={{ cursor: 'pointer', color: fundraiser.showMissions ? 'blue' : 'black' }}>{fundraiser.name}</h2>
              <p>Goal: {fundraiser.goal_amount} {fundraiser.goal_currency}</p>
              <p>Deadline: {fundraiser.goal_end_date ? new Date(fundraiser.goal_end_date).toLocaleDateString() : 'No deadline'}</p>
              <p>Missions: {fundraiser.missions_count}</p>
              <p>Total Raised: {fundraiser.total_raised} / {fundraiser.goal_amount} {fundraiser.goal_currency}</p>
              {fundraiser.showMissions && fundraiser.missions && (
                <div className="missions">
                  {fundraiser.missions.length === 0
                    ? (
                    <p>No missions available.</p>
                      )
                    : (
                        fundraiser.missions.map((mission) => (
                      <div key={mission.id} className="mission-card">
                        <h3 onClick={() => toggleDonations(fundraiser.id, mission.id)} style={{ cursor: 'pointer', color: mission.showDonations ? 'green' : 'black' }}>{mission.name}</h3>
                        <p>Goal: {mission.goal_amount} {mission.goal_currency}</p>
                        <p>Deadline: {mission.goal_end_date ? new Date(mission.goal_end_date).toLocaleDateString() : 'No deadline'}</p>
                        <p>Donations: {mission.donations_count}</p>
                        <p>Total Raised: {mission.total_raised} / {mission.goal_amount} {mission.goal_currency}</p>
                        {mission.showDonations && mission.donations && (
                          <div className="donations">
                            {mission.donations.length === 0
                              ? (
                              <p>No donations available.</p>
                                )
                              : (
                                  mission.donations.map((donation) => (
                                <div key={donation.id} className="donation-card">
                                  <p>Donor: {donation.donor ? `${donation.donor.first_name} ${donation.donor.last_name} (${donation.donor.email})` : 'Loading...'}</p>
                                  <p>Amount: {donation.amount} {mission.goal_currency}</p>
                                </div>
                                  ))
                                )}
                          </div>
                        )}
                      </div>
                        ))
                      )}
                </div>
              )}
            </div>
              ))
            )}
        <div className="pagination">
          <button onClick={() => setPage(page - 1)} disabled={page === 1}>Previous</button>
          <button onClick={() => setPage(page + 1)} disabled={page >= totalPages}>Next</button>
        </div>
      </div>
    </>
  )
}

export default Fundraisers
