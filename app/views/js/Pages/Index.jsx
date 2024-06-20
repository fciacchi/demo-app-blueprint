import React, { useEffect, useState, useRef } from 'react'
import { Head } from '@inertiajs/react'
import axios from 'axios'

const Fundraisers = () => {
  const [fundraisers, setFundraisers] = useState([])
  const [loading, setLoading] = useState(true)
  const [error, setError] = useState(null)
  const [page, setPage] = useState(1)
  const [totalPages, setTotalPages] = useState(1)
  const [employeeCache, setEmployeeCache] = useState({})
  // eslint-disable-next-line no-unused-vars
  const [missionCache, setMissionCache] = useState({})
  // eslint-disable-next-line no-unused-vars
  const [donationCache, setDonationCache] = useState({})

  const fetchedFundraisersRef = useRef(new Set())

  useEffect(() => {
    const fetchFundraisers = async () => {
      try {
        const response = await axios.get(`/api/fundraisers?page=${page}`)
        setTotalPages(response.data._pages.total ?? 1)

        if (response.data && Array.isArray(response.data.fundraisers)) {
          const fundraisersList = response.data.fundraisers.map(fundraiser => ({
            ...fundraiser,
            missions_count: 'n/a',
            total_raised: 0,
            missions: [],
            showMissions: false
          }))
          setFundraisers(fundraisersList)
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

  useEffect(() => {
    const fetchMissionsAndDonations = async () => {
      for (const fundraiser of fundraisers) {
        if (!fetchedFundraisersRef.current.has(fundraiser.id)) {
          fetchedFundraisersRef.current.add(fundraiser.id)

          try {
            const missionsResponse = await axios.get(`/api/fundraisers/${fundraiser.id}/missions`)
            if (missionsResponse.data && Array.isArray(missionsResponse.data.missions)) {
              const missions = await Promise.all(
                missionsResponse.data.missions.map(async (mission) => {
                  if (donationCache[mission.id]) {
                    mission.donations = donationCache[mission.id]
                  } else {
                    try {
                      const donationsResponse = await axios.get(`/api/fundraisers/${fundraiser.id}/missions/${mission.id}/donations`)
                      if (donationsResponse.data && Array.isArray(donationsResponse.data.donations)) {
                        mission.donations = donationsResponse.data.donations
                        donationCache[mission.id] = mission.donations
                      } else {
                        mission.donations = []
                      }
                      mission.donations_count = mission.donations.length
                      mission.total_raised = mission.donations.reduce((total, donation) => total + donation.amount, 0)
                    } catch (donationsError) {
                      mission.donations = []
                      mission.donations_count = 0
                      mission.total_raised = 0
                    }
                  }
                  return mission
                })
              )
              missionCache[fundraiser.id] = missions
              fundraiser.missions = missions
              fundraiser.missions_count = missions.length
              fundraiser.total_raised = missions.reduce((total, mission) => total + mission.total_raised, 0)
            } else {
              fundraiser.missions = []
            }
            setFundraisers(fundraisers => fundraisers.map(f => f.id === fundraiser.id ? { ...fundraiser } : f))
          } catch (missionsError) {
            fundraiser.missions = []
          }
        }
      }
    }

    if (!loading) {
      fetchMissionsAndDonations()
    }
  }, [loading, fundraisers])

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
                  const uniqueEmployeeIds = [...new Set(mission.donations.map(donation => donation.employee_id))]
                  const employeeFetchPromises = uniqueEmployeeIds
                    .filter(employeeId => !employeeCache[employeeId])
                    .map(async employeeId => {
                      try {
                        const response = await axios.get(`/api/employees/${employeeId}`)
                        employeeCache[employeeId] = response.data
                      } catch (error) {
                        employeeCache[employeeId] = { first_name: 'Unknown', last_name: '', email: '' }
                      }
                    })
                  await Promise.all(employeeFetchPromises)
                  setEmployeeCache({ ...employeeCache })
                  mission.donations = mission.donations.map(donation => {
                    donation.donor = employeeCache[donation.employee_id]
                    return donation
                  })
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
              <h2
                onClick={() => toggleMissions(fundraiser.id)}
                style={{ cursor: 'pointer', color: fundraiser.showMissions ? 'blue' : 'black' }}
              >
                {fundraiser.name}
              </h2>
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
                        <h3
                          onClick={() => toggleDonations(fundraiser.id, mission.id)}
                          style={{ cursor: 'pointer', color: mission.showDonations ? 'green' : 'black' }}
                        >
                          {mission.name}
                        </h3>
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
