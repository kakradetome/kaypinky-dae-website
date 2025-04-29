<?php
/*===================================================================================================================================
                                                        USERS
====================================================================================================================================*/
/*===================================================================================================================================
                                                   Delete user
====================================================================================================================================*/
/*
    This function deletes a user in the database
    
    @param databaseConnection A connection handel to the database
    @param $userToBeDeletedId The id of the user to be deleted
    @return 
*/

    function deleteUser ( $databaseConnection, $userToBeDeletedId ) {
        
        /* Sanitize all data for sql */
        $userToBeDeletedId = mres( $databaseConnection, $userToBeDeletedId );
        
        $sql = "DELETE FROM users ";
        $sql .= "WHERE id = '" . $userToBeDeletedId . "' ";
        $sql .= "LIMIT 1";
        
         /* We need to delete the user's temporary password from the database. Let's check to make sure the user has a record there or not */
        $counOfUserByUserId = getCountOfRowsByUserId( $databaseConnection, $userToBeDeletedId, "userTemporaryPasswords" );
        
        /* If the user was found, ... */
        if( $counOfUserByUserId > 0) {
            /* Delete the user. Don't do anything with the user for now. */
            $existingUserTemporaryPasswordSuccessfullyDeleted= deleteUserTemporaryPasswordByUserId( $databaseConnection, $userToBeDeletedId );
        }
        
//        echo( $sql );
//        exit();
        
        $existingUserSuccessfullyDeleted = mysqli_query( $databaseConnection, $sql );
        
        if( $existingUserSuccessfullyDeleted ) {
            return true;
        } else {
            /* Insert failed */
            echo( mysqli_error( $databaseConnection ) );
            disconnectFromDatabase( $databaseConnection );
            exit(); /* Make sure it completely exits */
        }
    }
/*===================================================================================================================================
                                                        TEMPORARY PASSWORDS
====================================================================================================================================*/
/*===================================================================================================================================
                                                   Delete user temporary password by user Id
====================================================================================================================================*/
/*
    This function deletes a user's temporary password in the database
    
    @param databaseConnection A connection handle to the database
    @param $userToBeDeletedId The id of the user to be deleted
    @return 
*/

    function deleteUserTemporaryPasswordByUserId ( $databaseConnection, $userToBeDeletedId ) {
        
        /* Sanitize all data for sql */
        $userToBeDeletedId = mres( $databaseConnection, $userToBeDeletedId );
        
        $sql = "DELETE FROM userTemporaryPasswords ";
        $sql .= "WHERE userId = '" . $userToBeDeletedId . "' ";
        $sql .= "LIMIT 1";
        
//        echo( $sql );
//        exit();
        
        $existingUserTemporaryPasswordSuccessfullyDeleted = mysqli_query( $databaseConnection, $sql );
        
        if( $existingUserTemporaryPasswordSuccessfullyDeleted ) {
            return true;
        } else {
            /* Delete failed */
            echo( mysqli_error( $databaseConnection ) );
            disconnectFromDatabase( $databaseConnection );
            exit(); /* Make sure it completely exits */
        }
    }
?>