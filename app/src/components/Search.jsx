/**
 * Search
 * 
 * This is a component that allows the user to
 * search for specific content that is retrieved 
 * from the api.
 * 
 * @author Luke Walpole W20020794
 */
 
function Search(props) {
    return (
        <input placeholder='Search' className='text-blue border m-2 p-2 rounded-md outline-none bg-light-blue focus:bg-grey placeholder-blue' 
        type="text" value={props.search} onChange={props.handleSearch} />
    )
}

export default Search;