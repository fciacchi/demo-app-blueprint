import React, { useEffect, useState } from 'react';
import { Link, Head } from '@inertiajs/react';
import axios from 'axios';

const Fundraisers = () => {
  const [fundraisers, setFundraisers] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [page, setPage] = useState(1);

  useEffect(() => {
    const fetchFundraisers = async () => {
      try {
        const response = await axios.get(`/api/fundraisers?page=${page}`);
        if (response.data && Array.isArray(response.data.fundraisers)) {
          setFundraisers(response.data.fundraisers);
        } else {
          throw new Error('Invalid data format');
        }
      } catch (err) {
        setError('Failed to fetch fundraisers');
      } finally {
        setLoading(false);
      }
    };

    fetchFundraisers();
  }, [page]);

  const toggleMissions = async (fundraiserId) => {
    const updatedFundraisers = fundraisers.map((fundraiser) => {
      if (fundraiser.id === fundraiserId) {
        fundraiser.showMissions = !fundraiser.showMissions;
        if (fundraiser.showMissions && !fundraiser.missions) {
          axios.get(`/api/fundraisers/${fundraiserId}/missions`).then((response) => {
            if (response.data && Array.isArray(response.data.missions)) {
              fundraiser.missions = response.data.missions;
            } else {
              fundraiser.missions = [];
            }
            setFundraisers([...fundraisers]);
          });
        }
      }
      return fundraiser;
    });
    setFundraisers(updatedFundraisers);
  };

  const toggleDonations = async (fundraiserId, missionId) => {
    const updatedFundraisers = fundraisers.map((fundraiser) => {
      if (fundraiser.id === fundraiserId) {
        fundraiser.missions = fundraiser.missions.map((mission) => {
          if (mission.id === missionId) {
            mission.showDonations = !mission.showDonations;
            if (mission.showDonations && !mission.donations) {
              axios.get(`/api/fundraisers/${fundraiserId}/missions/${missionId}/donations`).then((response) => {
                if (response.data && Array.isArray(response.data.donations)) {
                  mission.donations = response.data.donations;
                } else {
                  mission.donations = [];
                }
                setFundraisers([...fundraisers]);
              });
            }
          }
          return mission;
        });
      }
      return fundraiser;
    });
    setFundraisers(updatedFundraisers);
  };

  if (loading) {
    return <div>Loading...</div>;
  }

  if (error) {
    return <div>{error}</div>;
  }

  return (
    <>
      <Head title="Fundraisers" />
      <div className="container">
        <h1>Fundraisers</h1>
        {fundraisers.length === 0 ? (
          <p>No fundraisers available.</p>
        ) : (
          fundraisers.map((fundraiser) => (
            <div key={fundraiser.id} className="card">
              <h2 onClick={() => toggleMissions(fundraiser.id)} style={{ cursor: 'pointer' }}>{fundraiser.name}</h2>
              <p>Goal: {fundraiser.goal_amount} {fundraiser.goal_currency}</p>
              <p>Deadline: {fundraiser.goal_end_date ? new Date(fundraiser.goal_end_date).toLocaleDateString() : 'No deadline'}</p>
              <p>Missions: {fundraiser.missions_count}</p>
              <p>Total Raised: {fundraiser.total_raised} / {fundraiser.goal_amount} {fundraiser.goal_currency}</p>
              {fundraiser.showMissions && fundraiser.missions && (
                <div className="missions">
                  {fundraiser.missions.length === 0 ? (
                    <p>No missions available.</p>
                  ) : (
                    fundraiser.missions.map((mission) => (
                      <div key={mission.id} className="mission-card">
                        <h3 onClick={() => toggleDonations(fundraiser.id, mission.id)} style={{ cursor: 'pointer' }}>{mission.name}</h3>
                        <p>Goal: {mission.goal_amount} {mission.goal_currency}</p>
                        <p>Deadline: {mission.goal_end_date ? new Date(mission.goal_end_date).toLocaleDateString() : 'No deadline'}</p>
                        <p>Donations: {mission.donations_count}</p>
                        <p>Total Raised: {mission.total_raised} / {mission.goal_amount} {mission.goal_currency}</p>
                        {mission.showDonations && mission.donations && (
                          <div className="donations">
                            {mission.donations.length === 0 ? (
                              <p>No donations available.</p>
                            ) : (
                              mission.donations.map((donation) => (
                                <div key={donation.id} className="donation-card">
                                  <p>Donor: {donation.donor_name}</p>
                                  <p>Amount: {donation.amount} {donation.goal_currency}</p>
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
          <button onClick={() => setPage(page + 1)}>Next</button>
        </div>
      </div>
    </>
  );
};

export default Fundraisers;
