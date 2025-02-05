import { useEffect, useState } from 'react'
import Search from '../components/Search'
import Country from '../components/Country'
 
/**
 * CountryListing
 * 
 * This is the country list component. It fetches
 * data from the web API and displays information
 * from the country endpoint.
 * 
 * @author Luke Walpole W20020794
 */
 
function CountriesListing() {
 
 
    const [countries, setCountries] = useState([])
    const [search, setSearch] = useState('')
 
 
    useEffect( () => {
        fetchData()
    },[])
 
 
    const handleResponse = (response) => {
        if (response.status === 200) {
            return response.json()
        } else {
            throw new Error("invalid response: " + response.status)
        }
    }
     
    const handleJSON = (json) => {
        if (json.constructor === Array) {
            console.log(json)
            setCountries(json)
        } else {
            throw new Error("invalid JSON: " + json)
        }
    }
     
    const fetchData = () => { 
        fetch('https://w20020794.nuwebspace.co.uk/coursework/api/country')
        .then( response => handleResponse(response) )
        .then( json => handleJSON(json) )
        .catch( err => { console.log(err.message) })
    }
 
 
    // function used for filtering countries    
    const searchCountries = (country) => {
        const foundInCountry = country.country.toLowerCase().includes(search.toLowerCase())
        const foundInCity = country.city.toLowerCase().includes(search.toLowerCase())
        const foundInInstitution = country.institution.toLowerCase().includes(search.toLowerCase())
        return foundInCountry || foundInCity || foundInInstitution
    }
 
 
    // Add a filter to the map function
    const countriesJSX = countries.filter(searchCountries).map( 
        (country, i) => <Country key={i + country.country} count={i} country={country} /> 
    ) 
 
 
    // update state when the search input changes
    const handleSearch = (event) => {
        setSearch(event.target.value)
    }
 
 
    return (
        <>
            <h1 className='text-4xl text-red text-left m-2 p-2'>Countries</h1>
            <Search search={search} handleSearch={handleSearch} />
            <div className="grid md:grid-cols-2 lg:grid-cols-4 text-blue">
            {countriesJSX}
            </div>
        </>
    )
}
 
export default CountriesListing