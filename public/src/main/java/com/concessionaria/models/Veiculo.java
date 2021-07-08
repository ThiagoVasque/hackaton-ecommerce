package com.concessionaria.models;



import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.JoinColumn;
import javax.persistence.ManyToOne;



@Entity
public class Veiculo {
	
	@Id
	@GeneratedValue(strategy = GenerationType.IDENTITY)
	private Long id;
	private String modelo;
	
	
	private String anomodelo;
	
	
	private String anofabricacao;
	
	private Double valor;
	
	
	@Column(name="tipo")
	private String tipo;
	private String fotodestaque;
	
	@ManyToOne
	@JoinColumn(name="marca_id")
	private Marca marca;
	
	@ManyToOne
	@JoinColumn(name="cor_id")
	private Cor cor;
	
	
	
	protected Veiculo() {
		
	}
	public Long getId() {
		return id;
	}

	public String getModelo() {
		return modelo;
	}

	public String getAnomodelo() {
		return anomodelo;
	}
	public String getAnofabricacao() {
		return anofabricacao;
	}
	public String getFotodestaque() {
		return fotodestaque;
	}
	public Double getValor() {
		return valor;
	}

	public String getTipo() {
		return tipo;
	}

	public String getFotoDestaque() {
		return fotodestaque;
	}

	public Marca getMarca() {
		return marca;
	}

	public Cor getCor() {
		return cor;
	}

}
