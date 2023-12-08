<?php
include 'includes/session.php';
include 'includes/header.php';
//include 'includes/DatabaseCon.php';
?> 
<?php 
class VotersPage
{
    private $conn;

    public function __construct()
    {
        $db = new Database();
        $this->conn = $db->getConnection();
    }

    public function displayPage()
    {
        // The rest of your code...
        $sql = "SELECT * FROM voters";
        $query = $this->conn->query($sql);

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
          $voter = new Voter($row);
          $voter->displayRow();
      }
  }
}

class Voter
{
  private $id;
  private $firstname;
  private $lastname;
  private $photo;
  private $votersId;

  public function __construct($data)
  {
      $this->id = $data['id'];
      $this->firstname = $data['firstname'];
      $this->lastname = $data['lastname'];
      $this->photo = $data['photo'];
      $this->votersId = $data['voters_id'];
  }

  public function displayRow()
  {
      $image = (!empty($this->photo)) ? '../images/' . $this->photo : '../images/profile.jpg';
      echo "
          <tr>
              <td>{$this->lastname}</td>
              <td>{$this->firstname}</td>
              <td>
                  <img src='{$image}' width='30px' height='30px'>
                  <a href='#edit_photo' data-toggle='modal' class='pull-right photo' data-id='{$this->id}'><span class='fa fa-edit'></span></a>
              </td>
              <td>{$this->votersId}</td>
              <td>
                  <button class='btn btn-success btn-sm edit btn-flat' data-id='{$this->id}'><i class='fa fa-edit'></i> Edit</button>
                  <button class='btn btn-danger btn-sm delete btn-flat' data-id='{$this->id}'><i class='fa fa-trash'></i> Delete</button>
              </td>
          </tr>
      ";
  }
}

$votersPage = new VotersPage();
$votersPage->displayPage();

include 'includes/footer.php';
include 'includes/voters_modal.php';
include 'includes/scripts.php';
?>
<script>
$(function(){
  $(document).on('click', '.edit', function(e){
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.photo', function(e){
    e.preventDefault();
    var id = $(this).data('id');
    getRow(id);
  });

});

function getRow(id){
  $.ajax({
    type: 'POST',
    url: 'voters_row.php',
    data: {id:id},
    dataType: 'json',
    success: function(response){
      $('.id').val(response.id);
      $('#edit_firstname').val(response.firstname);
      $('#edit_lastname').val(response.lastname);
      $('#edit_password').val(response.password);
      $('.fullname').html(response.firstname+' '+response.lastname);
    }
  });
}

</script>
</body>
</html>